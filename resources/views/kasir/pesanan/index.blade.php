@extends('layouts.app')

@section('title', 'Daftar Pesanan Real-Time')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-100 flex items-center gap-2">
                Daftar Pesanan
                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                    <span class="w-1.5 h-1.5 mr-1.5 bg-emerald-400 rounded-full animate-ping"></span> Live
                </span>
            </h1>
            <p class="text-xs text-slate-400">Status pesanan real-time di Warkop Pak Yos (Otomatis memperbarui tampilan)</p>
        </div>
        <div class="flex items-center space-x-3">
            <button onclick="location.reload();" class="px-3 py-2 bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 text-xs font-semibold rounded-lg transition flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                Refresh Manual
            </button>
            <a href="/pesanan/create" class="px-4 py-2 bg-amber-500 hover:bg-amber-400 text-slate-900 font-bold text-xs rounded-lg transition shadow-lg shadow-amber-500/20">
                + Pesanan Baru
            </a>
        </div>
    </div>

    <div class="bg-slate-800 border border-slate-700 rounded-xl overflow-hidden shadow-xl">
        <table class="w-full text-left text-sm text-slate-200">
            <thead class="bg-slate-900/60 text-slate-400 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3">ID Pesanan</th>
                    <th class="px-6 py-3">Jenis</th>
                    <th class="px-6 py-3">Meja</th>
                    <th class="px-6 py-3">Kasir</th>
                    <th class="px-6 py-3">Status Pesanan</th>
                    <th class="px-6 py-3">Status Pembayaran</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-700">
                @forelse($pesanan as $row)
                    <tr class="hover:bg-slate-700/50">
                        <td class="px-6 py-4 font-mono text-amber-400 font-bold">{{ $row->id_pesanan }}</td>
                        <td class="px-6 py-4 capitalize font-medium">{{ $row->jenis_pesanan }}</td>
                        <td class="px-6 py-4">
                            @if($row->meja)
                                <span class="px-2 py-0.5 rounded bg-slate-900 border border-slate-700 text-slate-200 text-xs font-semibold">
                                    Meja {{ $row->meja->nomor_meja }}
                                </span>
                            @else
                                <span class="text-slate-500 text-xs">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-300">{{ $row->kasir->nama_karyawan ?? '-' }}</td>
                        <td class="px-6 py-4">
                            @if($row->status_pesanan === 'baru')
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-amber-500/10 text-amber-400 border border-amber-500/20">Baru</span>
                            @elseif($row->status_pesanan === 'diproses')
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-blue-500/10 text-blue-400 border border-blue-500/20">Diproses</span>
                            @elseif($row->status_pesanan === 'selesai')
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Selesai</span>
                            @else
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-purple-500/10 text-purple-400 border border-purple-500/20">Terkirim</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($row->pembayaran)
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-emerald-500/20 text-emerald-300">
                                    Lunas ({{ $row->pembayaran->metode_pembayaran }})
                                </span>
                            @else
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-red-500/10 text-red-400 border border-red-500/20">
                                    Belum Dibayar
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            @if(!$row->pembayaran)
                                <a href="/pembayaran/create/{{ $row->id_pesanan }}" class="px-3 py-1.5 bg-emerald-500 hover:bg-emerald-400 text-slate-900 font-bold text-xs rounded transition shadow shadow-emerald-500/20">
                                    Bayar Sekarang
                                </a>
                            @else
                                <span class="text-xs text-slate-500 font-mono">Completed</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-slate-500">Belum ada pesanan recorded.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    // Auto refresh halaman setiap 15 detik untuk memantau perubahan status pesanan dari koki/barista
    setInterval(function() {
        location.reload();
    }, 15000);
</script>
@endsection
