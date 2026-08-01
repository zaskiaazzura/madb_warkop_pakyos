@extends('layouts.app')

@section('title', 'Buat Pesanan Baru')

@section('content')
<div class="max-w-3xl mx-auto bg-slate-800 border border-slate-700 rounded-xl p-6 shadow-2xl">
    <div class="flex items-center justify-between mb-6 border-b border-slate-700 pb-4">
        <div>
            <h2 class="text-xl font-bold text-slate-100">Formulir Pesanan Baru</h2>
            <p class="text-xs text-slate-400">Kasir: <span class="text-amber-400 font-semibold">{{ auth()->user()->username }}</span> (Petugas diset otomatis oleh sistem)</p>
        </div>
        <span class="px-3 py-1 bg-amber-500/10 border border-amber-500/30 text-amber-400 text-xs rounded-full font-mono">CALL sp_buat_pesanan_baru</span>
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

    <form method="POST" action="/pesanan" class="space-y-6">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase mb-1">Jenis Pesanan</label>
                <select name="jenis_pesanan" id="jenis_pesanan" required
                    class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-slate-100 text-sm focus:outline-none focus:border-amber-500">
                    <option value="dine-in">Dine-in (Makan di Tempat)</option>
                    <option value="takeaway">Takeaway (Bawa Pulang)</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase mb-1">Nomor Meja (Khusus Dine-in)</label>
                <select name="id_meja" id="id_meja"
                    class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-slate-100 text-sm focus:outline-none focus:border-amber-500">
                    <option value="">-- Pilih Meja Kosong --</option>
                    @foreach($meja as $m)
                        <option value="{{ $m->id_meja }}">Meja {{ $m->nomor_meja }} ({{ $m->id_meja }})</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="border-t border-slate-700 pt-4">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-sm font-bold text-amber-400 uppercase tracking-wider">Item Menu Pesanan</h3>
                <button type="button" id="add-item-btn" class="px-3 py-1 bg-slate-700 hover:bg-slate-600 text-slate-200 text-xs font-semibold rounded transition">
                    + Tambah Baris Menu
                </button>
            </div>

            <div id="items-container" class="space-y-3">
                <div class="grid grid-cols-12 gap-2 items-center bg-slate-900/60 p-3 rounded-lg border border-slate-700/50 item-row">
                    <div class="col-span-8">
                        <label class="block text-[10px] text-slate-400 uppercase mb-1">Pilih Menu</label>
                        <select name="items[0][id_menu]" required class="w-full bg-slate-800 border border-slate-700 rounded px-2 py-1.5 text-xs text-slate-100 focus:border-amber-500">
                            @foreach($menu as $mn)
                                <option value="{{ $mn->id_menu }}">
                                    [{{ strtoupper($mn->kategori) }}] {{ $mn->nama_menu }} - Rp {{ number_format($mn->harga, 0, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-span-3">
                        <label class="block text-[10px] text-slate-400 uppercase mb-1">Jumlah</label>
                        <input type="number" name="items[0][jumlah]" value="1" min="1" required class="w-full bg-slate-800 border border-slate-700 rounded px-2 py-1.5 text-xs text-slate-100 text-center focus:border-amber-500">
                    </div>

                    <div class="col-span-1 text-right pt-4">
                        <button type="button" class="text-red-400 hover:text-red-300 text-xs remove-row-btn">&times;</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end space-x-3 pt-4 border-t border-slate-700">
            <a href="/pesanan" class="px-4 py-2 bg-slate-700 hover:bg-slate-600 text-slate-200 text-xs font-semibold rounded-lg transition">Batal</a>
            <button type="submit" class="px-5 py-2 bg-amber-500 hover:bg-amber-400 text-slate-900 font-bold text-xs rounded-lg transition shadow-lg shadow-amber-500/20">
                Simpan & Proses (CALL SP)
            </button>
        </div>
    </form>
</div>

<script>
    let itemIndex = 1;
    document.getElementById('add-item-btn').addEventListener('click', function () {
        const container = document.getElementById('items-container');
        const firstRow = container.querySelector('.item-row');
        const newRow = firstRow.cloneNode(true);

        newRow.querySelector('select').name = `items[${itemIndex}][id_menu]`;
        newRow.querySelector('input[type="number"]').name = `items[${itemIndex}][jumlah]`;
        newRow.querySelector('input[type="number"]').value = 1;

        container.appendChild(newRow);
        itemIndex++;
    });

    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('remove-row-btn')) {
            const rows = document.querySelectorAll('.item-row');
            if (rows.length > 1) {
                e.target.closest('.item-row').remove();
            }
        }
    });
</script>
@endsection
