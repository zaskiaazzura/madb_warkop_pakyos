<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\Meja;
use App\Models\Menu;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PesananController extends Controller
{
    public function index()
    {
        $pesanan = Pesanan::with(['meja', 'kasir', 'detailPesanan.menu', 'pembayaran'])->orderBy('created_at', 'desc')->get();
        return view('kasir.pesanan.index', compact('pesanan'));
    }

    public function create()
    {
        $meja = Meja::where('status_meja', 'kosong')->get();
        $menu = Menu::where('status_ketersediaan', 'tersedia')->get();
        return view('kasir.pesanan.create', compact('meja', 'menu'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_meja'       => 'nullable|string|exists:meja,id_meja',
            'jenis_pesanan' => 'required|in:dine-in,takeaway',
            'items'         => 'required|array|min:1',
            'items.*.id_menu' => 'required|string|exists:menu,id_menu',
            'items.*.jumlah' => 'required|integer|min:1',
        ]);

        if ($validated['jenis_pesanan'] === 'dine-in' && empty($validated['id_meja'])) {
            return back()->withErrors(['id_meja' => 'Untuk pesanan dine-in, meja harus dipilih!'])->withInput();
        }

        $idKasir = auth()->user()->id_karyawan ?? 'KRW001';

        DB::transaction(function () use ($validated, $idKasir) {
            $idPesanan = $this->generateNextId('pesanan', 'id_pesanan', 'PSN');
            $idMeja = $validated['jenis_pesanan'] === 'dine-in' ? $validated['id_meja'] : null;

            if (in_array(DB::getDriverName(), ['mysql', 'mariadb'])) {
                DB::statement('CALL sp_buat_pesanan_baru(?, ?, ?, ?)', [
                    $idPesanan,
                    $idMeja,
                    $idKasir,
                    $validated['jenis_pesanan']
                ]);
            } else {
                Pesanan::create([
                    'id_pesanan'     => $idPesanan,
                    'id_meja'        => $idMeja,
                    'id_kasir'       => $idKasir,
                    'jenis_pesanan'  => $validated['jenis_pesanan'],
                    'tanggal_waktu'  => now(),
                    'status_pesanan' => 'baru',
                ]);
                if ($validated['jenis_pesanan'] === 'dine-in' && !empty($idMeja)) {
                    Meja::where('id_meja', $idMeja)->update(['status_meja' => 'terisi']);
                }
            }

            $koki = Karyawan::where('peran', 'koki')->first();
            $barista = Karyawan::where('peran', 'barista')->first();

            foreach ($validated['items'] as $item) {
                $menu = Menu::findOrFail($item['id_menu']);

                if ($menu->kategori === 'makanan') {
                    $idPetugas = $koki ? $koki->id_karyawan : $idKasir;
                } elseif ($menu->kategori === 'minuman') {
                    $idPetugas = $barista ? $barista->id_karyawan : $idKasir;
                } else {
                    $idPetugas = $koki ? $koki->id_karyawan : ($barista ? $barista->id_karyawan : $idKasir);
                }

                $idDetail = $this->generateNextId('detailpesanan', 'id_detail_pesanan', 'DPS');

                if (in_array(DB::getDriverName(), ['mysql', 'mariadb'])) {
                    DB::statement('CALL sp_tambah_detail_pesanan(?, ?, ?, ?, ?)', [
                        $idDetail,
                        $idPesanan,
                        $item['id_menu'],
                        $idPetugas,
                        (int) $item['jumlah']
                    ]);
                } else {
                    $subtotal = $menu->harga * $item['jumlah'];
                    DetailPesanan::create([
                        'id_detail_pesanan' => $idDetail,
                        'id_pesanan'        => $idPesanan,
                        'id_menu'           => $item['id_menu'],
                        'id_petugas'        => $idPetugas,
                        'jumlah'            => $item['jumlah'],
                        'subtotal'          => $subtotal,
                        'status_item'       => 'menunggu',
                    ]);
                }
            }
        });

        return redirect()->route('pesanan.index')->with('success', 'Pesanan berhasil dibuat!');
    }

    private function generateNextId(string $table, string $primaryKey, string $prefix, int $padLength = 3): string
    {
        $latest = DB::table($table)
            ->where($primaryKey, 'LIKE', $prefix . '%')
            ->orderByRaw("CAST(SUBSTRING({$primaryKey}, " . (strlen($prefix) + 1) . ") AS UNSIGNED) DESC")
            ->first();

        if ($latest) {
            $number = (int) substr($latest->{$primaryKey}, strlen($prefix)) + 1;
        } else {
            $number = 1;
        }

        return $prefix . str_pad((string)$number, $padLength, '0', STR_PAD_LEFT);
    }
}
