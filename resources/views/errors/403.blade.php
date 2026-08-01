@extends('layouts.app')

@section('title', '403 Forbidden')

@section('content')
<div class="max-w-md mx-auto mt-16 text-center bg-slate-800 border border-slate-700 rounded-xl p-8 shadow-2xl">
    <div class="inline-flex items-center justify-center w-16 h-16 bg-red-500/10 text-red-500 rounded-full mb-4">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
        </svg>
    </div>
    <h1 class="text-4xl font-extrabold text-red-500 mb-2">403</h1>
    <h2 class="text-lg font-bold text-slate-200 mb-2">Akses Ditolak / Forbidden</h2>
    <p class="text-xs text-slate-400 mb-6">
        {{ $exception->getMessage() ?: 'Anda tidak memiliki wewenang untuk mengakses halaman ini.' }}
    </p>
    <a href="javascript:history.back()" class="px-4 py-2 bg-slate-700 hover:bg-slate-600 text-slate-200 text-xs font-semibold rounded-lg transition">
        Kembali ke Halaman Sebelumnya
    </a>
</div>
@endsection
