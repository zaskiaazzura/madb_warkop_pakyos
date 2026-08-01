@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="max-w-md mx-auto mt-12 bg-slate-800 border border-slate-700 rounded-xl p-8 shadow-2xl">
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-slate-100">Login Sistem Warkop</h2>
        <p class="text-xs text-slate-400 mt-1">Masukkan username dan password Anda untuk beraktivitas</p>
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

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf
        <div>
            <label for="username" class="block text-xs font-semibold text-slate-300 uppercase mb-1">Username</label>
            <input type="text" id="username" name="username" value="{{ old('username') }}" required autofocus
                class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-slate-100 text-sm focus:outline-none focus:border-amber-500">
        </div>

        <div>
            <label for="password" class="block text-xs font-semibold text-slate-300 uppercase mb-1">Password</label>
            <input type="password" id="password" name="password" required
                class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-slate-100 text-sm focus:outline-none focus:border-amber-500">
        </div>

        <div class="flex items-center justify-between text-xs text-slate-400">
            <label class="flex items-center space-x-2 cursor-pointer">
                <input type="checkbox" name="remember" class="rounded bg-slate-900 border-slate-700 text-amber-500">
                <span>Ingat Saya</span>
            </label>
        </div>

        <button type="submit"
            class="w-full py-2.5 bg-amber-500 hover:bg-amber-400 text-slate-900 font-bold text-sm rounded-lg transition shadow-lg shadow-amber-500/20">
            Masuk
        </button>
    </form>
</div>
@endsection
