@extends('layouts.app')

@section('title', 'Input Pembayaran')

@section('content')
<div class="max-w-2xl mx-auto bg-slate-800 border border-slate-700 rounded-xl p-6 shadow-2xl">
    <div class="flex items-center justify-between mb-6 border-b border-slate-700 pb-4">
        <div>
            <h2 class="text-xl font-bold text-slate-100">Proses Pembayaran Pesanan</h2>
            <p class="text-xs text-slate-400">Validasi aturan BR-11 (Pembayaran 1:1 unik per pesanan)</p>
        </div>
        <span class="px-3 py-1 bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-xs rounded-full font-mono">CALL sp_proses_pembayaran</span>
    </div>

    @if ($errors->any())
        <div class="mb-4 p-3 rounded bg-red-500/10 border border-red-500/20 text-red-400 text-xs">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="/pembayaran" class="space-y-6">
        @csrf
        <div>
            <label class="block text-xs font-semibold text-slate-300 uppercase mb-1">Pilih ID Pesanan</label>
            <select name="id_pesanan" id="select_pesanan" required onchange="location = this.value ? '/pembayaran/create/' + this.value : '/pembayaran/create';"
                class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-slate-100 text-sm focus:outline-none focus:border-amber-500">
                <option value="">-- Pilih Pesanan Belum Dibayar --</option>
                @foreach($pesananList as $p)
                    <option value="{{ $p->id_pesanan }}" {{ ($selectedId === $p->id_pesanan) ? 'selected' : '' }}>
                        {{ $p->id_pesanan }} - {{ strtoupper($p->jenis_pesanan) }} {{ $p->meja ? '(Meja '.$p->meja->nomor_meja.')' : '' }}
                    </option>
                @endforeach
            </select>
        </div>

        @if($pesananDetail)
            <div class="bg-slate-900/80 p-4 rounded-lg border border-slate-700 space-y-3">
                <h3 class="text-xs font-bold text-amber-400 uppercase tracking-wider">Ringkasan Pesanan ({{ $pesananDetail->id_pesanan }})</h3>
                <div class="divide-y divide-slate-800 text-xs">
                    @foreach($pesananDetail->detailPesanan as $item)
                        <div class="py-2 flex justify-between">
                            <span>{{ $item->menu->nama_menu ?? '-' }} x {{ $item->jumlah }}</span>
                            <span class="font-mono text-slate-300">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>
                <div class="pt-3 border-t border-slate-700 flex justify-between items-center text-sm font-bold">
                    <span class="text-slate-200">TOTAL TAGIHAN:</span>
                    <span class="text-emerald-400 text-lg font-mono">Rp {{ number_format($totalTagihan, 0, ',', '.') }}</span>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase mb-1">Metode Pembayaran</label>
                <select name="metode_pembayaran" required class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-slate-100 text-sm focus:outline-none focus:border-amber-500">
                    <option value="tunai">Tunai</option>
                    <option value="QRIS">QRIS</option>
                    <option value="transfer">Transfer Bank</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase mb-1">Jumlah Bayar (Rp)</label>
                <input type="number" name="jumlah_bayar" step="0.01" value="{{ $totalTagihan }}" min="{{ $totalTagihan }}" required
                    class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-slate-100 text-sm font-mono text-emerald-400 focus:outline-none focus:border-amber-500">
            </div>

            <div class="flex justify-end space-x-3 pt-4 border-t border-slate-700">
                <a href="/pesanan" class="px-4 py-2 bg-slate-700 hover:bg-slate-600 text-slate-200 text-xs font-semibold rounded-lg transition">Batal</a>
                <button type="submit" class="px-5 py-2 bg-emerald-500 hover:bg-emerald-400 text-slate-900 font-bold text-xs rounded-lg transition shadow-lg shadow-emerald-500/20">
                    Proses Pembayaran (CALL SP)
                </button>
            </div>
        @else
            <div class="p-6 text-center text-slate-500 border border-dashed border-slate-700 rounded-lg text-xs">
                Silakan pilih salah satu ID Pesanan di atas untuk melihat ringkasan total tagihan.
            </div>
        @endif
    </form>
</div>
@endsection
