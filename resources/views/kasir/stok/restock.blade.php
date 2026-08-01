@extends('layouts.app')

@section('title', 'Restock Bahan Baku')

@section('content')
<div class="max-w-3xl mx-auto bg-slate-800 border border-slate-700 rounded-xl p-6 shadow-2xl">
    <div class="flex items-center justify-between mb-6 border-b border-slate-700 pb-4">
        <div>
            <h2 class="text-xl font-bold text-slate-100">Pembelian Stok Bahan Baku Baru</h2>
            <p class="text-xs text-slate-400">Restock stok bahan & update otomatis via <code class="text-amber-400">CALL sp_tambah_stok_bahan</code></p>
        </div>
        <span class="px-3 py-1 bg-amber-500/10 border border-amber-500/30 text-amber-400 text-xs rounded-full font-mono">CALL sp_tambah_stok_bahan</span>
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

    <form method="POST" action="/stok/restock" class="space-y-6">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase mb-1">Supplier</label>
                <select name="id_supplier" required class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-slate-100 text-sm focus:outline-none focus:border-amber-500">
                    <option value="">-- Pilih Supplier --</option>
                    @foreach($suppliers as $sup)
                        <option value="{{ $sup->id_supplier }}">{{ $sup->nama_supplier }} ({{ $sup->id_supplier }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase mb-1">Tanggal Pembelian</label>
                <input type="date" name="tanggal_pembelian" value="{{ date('Y-m-d') }}" required
                    class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-slate-100 text-sm focus:outline-none focus:border-amber-500">
            </div>
        </div>

        <div class="border-t border-slate-700 pt-4">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-sm font-bold text-amber-400 uppercase tracking-wider">Item Bahan Baku Dibeli</h3>
                <button type="button" id="add-bahan-btn" class="px-3 py-1 bg-slate-700 hover:bg-slate-600 text-slate-200 text-xs font-semibold rounded transition">
                    + Tambah Item Bahan
                </button>
            </div>

            <div id="bahan-container" class="space-y-3">
                <div class="grid grid-cols-12 gap-2 items-center bg-slate-900/60 p-3 rounded-lg border border-slate-700/50 bahan-row">
                    <div class="col-span-5">
                        <label class="block text-[10px] text-slate-400 uppercase mb-1">Bahan Baku</label>
                        <select name="items[0][id_bahan]" required class="w-full bg-slate-800 border border-slate-700 rounded px-2 py-1.5 text-xs text-slate-100 focus:border-amber-500">
                            @foreach($bahanBaku as $b)
                                <option value="{{ $b->id_bahan }}">
                                    {{ $b->nama_bahan }} (Stok saat ini: {{ $b->stok }} {{ $b->satuan }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-span-3">
                        <label class="block text-[10px] text-slate-400 uppercase mb-1">Jumlah</label>
                        <input type="number" step="0.01" name="items[0][jumlah]" value="1" min="0.01" required class="w-full bg-slate-800 border border-slate-700 rounded px-2 py-1.5 text-xs text-slate-100 text-center focus:border-amber-500">
                    </div>

                    <div class="col-span-3">
                        <label class="block text-[10px] text-slate-400 uppercase mb-1">Harga Satuan (Rp)</label>
                        <input type="number" step="0.01" name="items[0][harga_satuan]" value="10000" min="0" required class="w-full bg-slate-800 border border-slate-700 rounded px-2 py-1.5 text-xs text-slate-100 text-center focus:border-amber-500">
                    </div>

                    <div class="col-span-1 text-right pt-4">
                        <button type="button" class="text-red-400 hover:text-red-300 text-xs remove-bahan-btn">&times;</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end space-x-3 pt-4 border-t border-slate-700">
            <a href="/pesanan" class="px-4 py-2 bg-slate-700 hover:bg-slate-600 text-slate-200 text-xs font-semibold rounded-lg transition">Batal</a>
            <button type="submit" class="px-5 py-2 bg-amber-500 hover:bg-amber-400 text-slate-900 font-bold text-xs rounded-lg transition shadow-lg shadow-amber-500/20">
                Simpan & Tambah Stok (CALL SP)
            </button>
        </div>
    </form>
</div>

<script>
    let bahanIndex = 1;
    document.getElementById('add-bahan-btn').addEventListener('click', function () {
        const container = document.getElementById('bahan-container');
        const firstRow = container.querySelector('.bahan-row');
        const newRow = firstRow.cloneNode(true);

        newRow.querySelector('select').name = `items[${bahanIndex}][id_bahan]`;
        newRow.querySelectorAll('input[type="number"]')[0].name = `items[${bahanIndex}][jumlah]`;
        newRow.querySelectorAll('input[type="number"]')[1].name = `items[${bahanIndex}][harga_satuan]`;

        container.appendChild(newRow);
        bahanIndex++;
    });

    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('remove-bahan-btn')) {
            const rows = document.querySelectorAll('.bahan-row');
            if (rows.length > 1) {
                e.target.closest('.bahan-row').remove();
            }
        }
    });
</script>
@endsection
