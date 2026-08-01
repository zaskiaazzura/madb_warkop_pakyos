@extends('layouts.app')

@section('title', 'Dashboard Penjualan (Pemilik)')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-100">Dashboard Laporan Penjualan</h1>
            <p class="text-xs text-slate-400">Data agregasi harian yang bersumber dari View Database <code class="bg-slate-800 px-1.5 py-0.5 rounded text-amber-400 font-mono">v_laporan_penjualan_harian</code></p>
        </div>
        <button onclick="location.reload();" class="px-3 py-2 bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 text-xs font-semibold rounded-lg transition flex items-center gap-1.5">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
            Refresh Laporan
        </button>
    </div>

    <!-- Summary Metrics -->
    @php
        $totalPendapatanSemua = $laporan->sum('total_pendapatan');
        $totalTransaksiSemua = $laporan->sum('total_transaksi');
    @endphp
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-slate-800 border border-slate-700 rounded-xl p-5 shadow-xl flex items-center space-x-4">
            <div class="p-3 bg-emerald-500/10 text-emerald-400 rounded-lg border border-emerald-500/20">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <span class="text-xs text-slate-400 uppercase font-semibold">Total Pendapatan Terakumulasi</span>
                <h2 class="text-2xl font-extrabold text-emerald-400 font-mono mt-0.5">Rp {{ number_format($totalPendapatanSemua, 0, ',', '.') }}</h2>
            </div>
        </div>

        <div class="bg-slate-800 border border-slate-700 rounded-xl p-5 shadow-xl flex items-center space-x-4">
            <div class="p-3 bg-amber-500/10 text-amber-400 rounded-lg border border-amber-500/20">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <div>
                <span class="text-xs text-slate-400 uppercase font-semibold">Total Transaksi Selesai</span>
                <h2 class="text-2xl font-extrabold text-amber-400 font-mono mt-0.5">{{ $totalTransaksiSemua }} <span class="text-xs font-normal text-slate-400">transaksi</span></h2>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-slate-800 border border-slate-700 rounded-xl overflow-hidden shadow-xl">
        <div class="px-6 py-4 border-b border-slate-700 bg-slate-900/40">
            <h3 class="text-sm font-bold text-slate-200">Laporan Penjualan Per Tanggal (Diurutkan Terbaru)</h3>
        </div>
        <table class="w-full text-left text-sm text-slate-200">
            <thead class="bg-slate-900/60 text-slate-400 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3">Tanggal Transaksi</th>
                    <th class="px-6 py-3 text-center">Total Transaksi</th>
                    <th class="px-6 py-3 text-right">Total Pendapatan (Rp)</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-700">
                @forelse($laporan as $row)
                    <tr class="hover:bg-slate-700/50">
                        <td class="px-6 py-4 font-semibold text-amber-400 font-mono">{{ date('d F Y', strtotime($row->tanggal)) }}</td>
                        <td class="px-6 py-4 text-center font-bold text-slate-100">{{ $row->total_transaksi }} Pesanan</td>
                        <td class="px-6 py-4 text-right font-extrabold text-emerald-400 font-mono">
                            Rp {{ number_format($row->total_pendapatan, 0, ',', '.') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-12 text-center text-slate-500">
                            <p class="text-sm">Belum ada transaksi pembayaran yang selesai tercatat di sistem.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
