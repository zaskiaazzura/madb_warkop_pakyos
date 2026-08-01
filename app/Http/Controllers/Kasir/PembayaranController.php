<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Pembayaran;
use App\Models\Meja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
    public function create($id_pesanan = null)
    {
        if ($id_pesanan) {
            $pesananDetail = Pesanan::with(['meja', 'detailPesanan.menu'])
                ->where('id_pesanan', $id_pesanan)
                ->whereDoesntHave('pembayaran')
                ->firstOrFail();

            $totalTagihan = $pesananDetail->detailPesanan->sum('subtotal');

            return view('kasir.pembayaran.create', [
                'pesananList'   => [$pesananDetail],
                'selectedId'    => $id_pesanan,
                'pesananDetail' => $pesananDetail,
                'totalTagihan'  => $totalTagihan
            ]);
        }

        $pesananList = Pesanan::whereDoesntHave('pembayaran')
            ->with(['meja', 'detailPesanan'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('kasir.pembayaran.create', [
            'pesananList'   => $pesananList,
            'selectedId'    => null,
            'pesananDetail' => null,
            'totalTagihan'  => 0
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_pesanan'        => 'required|string|exists:pesanan,id_pesanan|unique:pembayaran,id_pesanan',
            'metode_pembayaran' => 'required|in:tunai,QRIS,transfer',
            'jumlah_bayar'      => 'required|numeric|min:0',
        ]);

        $pesanan = Pesanan::with('detailPesanan')->findOrFail($validated['id_pesanan']);
        $totalHarga = $pesanan->detailPesanan->sum('subtotal');

        if ($validated['jumlah_bayar'] < $totalHarga) {
            return back()->with('error', 'Jumlah bayar (Rp ' . number_format($validated['jumlah_bayar'], 0) . ') kurang dari total tagihan (Rp ' . number_format($totalHarga, 0) . ')!')->withInput();
        }

        DB::transaction(function () use ($validated, $pesanan) {
            $idPembayaran = $this->generateNextId('pembayaran', 'id_pembayaran', 'BYR');

            if (in_array(DB::getDriverName(), ['mysql', 'mariadb'])) {
                DB::statement('CALL sp_proses_pembayaran(?, ?, ?, ?)', [
                    $idPembayaran,
                    $validated['id_pesanan'],
                    $validated['metode_pembayaran'],
                    $validated['jumlah_bayar']
                ]);
            } else {
                Pembayaran::create([
                    'id_pembayaran'     => $idPembayaran,
                    'id_pesanan'        => $validated['id_pesanan'],
                    'metode_pembayaran' => $validated['metode_pembayaran'],
                    'jumlah_bayar'      => $validated['jumlah_bayar'],
                    'tanggal_bayar'     => now(),
                ]);

                $pesanan->update(['status_pesanan' => 'selesai']);

                if (!empty($pesanan->id_meja)) {
                    Meja::where('id_meja', $pesanan->id_meja)->update(['status_meja' => 'kosong']);
                }
            }
        });

        return redirect()->route('pesanan.index')->with('success', 'Pembayaran berhasil diproses!');
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
