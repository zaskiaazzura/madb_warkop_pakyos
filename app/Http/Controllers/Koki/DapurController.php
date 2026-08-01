<?php

namespace App\Http\Controllers\Koki;

use App\Http\Controllers\Controller;
use App\Models\DetailPesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DapurController extends Controller
{
    public function index()
    {
        $idKaryawan = auth()->user()->id_karyawan;

        $items = DetailPesanan::where('id_petugas', $idKaryawan)
            ->where('status_item', '!=', 'selesai')
            ->whereHas('menu', function ($query) {
                $query->where('kategori', 'makanan');
            })
            ->with(['pesanan.meja', 'menu'])
            ->orderBy('created_at', 'asc')
            ->get();

        return view('koki.dapur', compact('items'));
    }

    public function updateStatus(Request $request, DetailPesanan $detailPesanan)
    {
        Gate::authorize('update', $detailPesanan);

        $validated = $request->validate([
            'status_item' => 'required|in:menunggu,diproses,selesai',
        ]);

        $currentStatus = $detailPesanan->status_item;
        $nextStatus = $validated['status_item'];

        // Validasi urutan status tidak boleh melompat
        if ($currentStatus === 'menunggu' && $nextStatus !== 'diproses') {
            return back()->with('error', 'Pesanan dengan status "menunggu" hanya bisa diubah menjadi "diproses"!');
        }

        if ($currentStatus === 'diproses' && $nextStatus !== 'selesai') {
            return back()->with('error', 'Pesanan dengan status "diproses" hanya bisa diubah menjadi "selesai"!');
        }

        if ($currentStatus === 'selesai') {
            return back()->with('error', 'Pesanan yang sudah "selesai" tidak dapat diubah statusnya lagi.');
        }

        $detailPesanan->update(['status_item' => $nextStatus]);

        return redirect()->back()->with('success', "Status pesanan makanan berhasil diperbarui menjadi {$nextStatus}!");
    }
}
