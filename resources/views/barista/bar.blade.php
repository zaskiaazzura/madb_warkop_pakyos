@extends('layouts.app')

@section('title', 'Monitor Bar (Barista)')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-100 flex items-center gap-2">
                Monitor Bar (Barista)
                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-500/10 text-blue-400 border border-blue-500/20">
                    Kategori: Minuman
                </span>
            </h1>
            <p class="text-xs text-slate-400">Daftar item pesanan minuman yang ditugaskan kepada <span class="text-amber-400 font-semibold">{{ auth()->user()->username }}</span></p>
        </div>
        <button onclick="location.reload();" class="px-3 py-2 bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 text-xs font-semibold rounded-lg transition flex items-center gap-1.5 self-start">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
            Refresh Data
        </button>
    </div>

    <!-- Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($items as $item)
            <div class="bg-slate-800 border {{ $item->status_item === 'menunggu' ? 'border-amber-500/50 shadow-amber-500/5' : 'border-blue-500/50 shadow-blue-500/5' }} rounded-xl p-5 shadow-xl flex flex-col justify-between space-y-4">
                <div class="space-y-2">
                    <div class="flex items-center justify-between border-b border-slate-700 pb-3">
                        <div>
                            <span class="text-xs font-mono text-amber-400 font-bold block">{{ $item->id_detail_pesanan }}</span>
                            <span class="text-xs text-slate-400">Pesanan: {{ $item->id_pesanan }}</span>
                        </div>
                        <span class="px-2.5 py-1 text-xs font-bold rounded-lg bg-slate-900 border border-slate-700 text-slate-200">
                            {{ $item->pesanan->meja ? 'Meja ' . $item->pesanan->meja->nomor_meja : 'TAKEAWAY' }}
                        </span>
                    </div>

                    <div class="py-2">
                        <h3 class="text-lg font-bold text-slate-100">{{ $item->menu->nama_menu ?? 'Menu' }}</h3>
                        <p class="text-2xl font-extrabold text-amber-400 mt-1">{{ $item->jumlah }} <span class="text-xs font-normal text-slate-400">gelas/cangkir</span></p>
                    </div>
                </div>

                <div class="border-t border-slate-700/80 pt-3 flex items-center justify-between">
                    <div>
                        <span class="text-[10px] text-slate-400 block uppercase">Status Saat Ini</span>
                        @if($item->status_item === 'menunggu')
                            <span class="px-2 py-0.5 text-xs font-bold rounded bg-amber-500/20 text-amber-300">Menunggu</span>
                        @else
                            <span class="px-2 py-0.5 text-xs font-bold rounded bg-blue-500/20 text-blue-300">Diproses</span>
                        @endif
                    </div>

                    <form method="POST" action="/bar/detail/{{ $item->id_detail_pesanan }}/status">
                        @csrf
                        @method('PATCH')
                        @if($item->status_item === 'menunggu')
                            <input type="hidden" name="status_item" value="diproses">
                            <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs rounded-lg transition shadow-lg shadow-blue-600/20">
                                Mulai Racik &rarr;
                            </button>
                        @elseif($item->status_item === 'diproses')
                            <input type="hidden" name="status_item" value="selesai">
                            <button type="submit" class="px-4 py-2 bg-emerald-500 hover:bg-emerald-400 text-slate-900 font-bold text-xs rounded-lg transition shadow-lg shadow-emerald-500/20">
                                Selesai Dibuat &check;
                            </button>
                        @endif
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-slate-800/40 border border-slate-700/50 rounded-xl p-12 text-center text-slate-500">
                <svg class="w-12 h-12 mx-auto mb-3 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-sm font-medium">Tidak ada tugas pesanan minuman aktif untuk Anda saat ini.</p>
                <p class="text-xs text-slate-600 mt-1">Semua pesanan minuman telah selesai disajikan!</p>
            </div>
        @endforelse
    </div>
</div>

<script>
    setInterval(function() {
        location.reload();
    }, 15000);
</script>
@endsection
