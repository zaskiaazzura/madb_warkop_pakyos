<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use App\Models\BahanBaku;
use App\Models\PembelianStok;
use App\Models\DetailPembelianStok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StokController extends Controller
{
    public function restock()
    {
        $suppliers = Supplier::all();
        $bahanBaku = BahanBaku::all();
        return view('kasir.stok.restock', compact('suppliers', 'bahanBaku'));
    }

    public function storeRestock(Request $request)
    {
        $validated = $request->validate([
            'id_supplier'         => 'required|string|exists:supplier,id_supplier',
            'tanggal_pembelian'   => 'required|date',
            'items'               => 'required|array|min:1',
            'items.*.id_bahan'     => 'required|string|exists:bahan_baku,id_bahan',
            'items.*.jumlah'       => 'required|numeric|min:0.01',
            'items.*.harga_satuan' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($validated) {
            $totalPembelian = 0;
            foreach ($validated['items'] as $item) {
                $totalPembelian += $item['jumlah'] * $item['harga_satuan'];
            }

            $pembelian = PembelianStok::create([
                'id_supplier'       => $validated['id_supplier'],
                'tanggal_pembelian' => $validated['tanggal_pembelian'],
                'total_pembelian'   => $totalPembelian,
            ]);

            foreach ($validated['items'] as $item) {
                $pembelian->detailPembelianStok()->create([
                    'id_bahan'     => $item['id_bahan'],
                    'jumlah'       => $item['jumlah'],
                    'harga_satuan' => $item['harga_satuan'],
                ]);

                if (in_array(DB::getDriverName(), ['mysql', 'mariadb'])) {
                    DB::statement('CALL sp_tambah_stok_bahan(?, ?)', [
                        $item['id_bahan'],
                        $item['jumlah']
                    ]);
                } else {
                    BahanBaku::where('id_bahan', $item['id_bahan'])
                        ->increment('stok', $item['jumlah']);
                }
            }
        });

        return redirect()->route('pesanan.index')->with('success', 'Pembelian stok bahan baku berhasil disimpan!');
    }
}
