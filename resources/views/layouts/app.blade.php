<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warkop Pak Yos - @yield('title', 'System')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen flex flex-col">
    <!-- Navbar -->
    <nav class="bg-slate-800/80 backdrop-blur border-b border-slate-700 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Brand -->
                <div class="flex items-center space-x-3">
                    <span class="text-2xl font-bold bg-gradient-to-r from-amber-400 to-amber-600 bg-clip-text text-transparent">
                        Warkop Pak Yos
                    </span>
                    @auth
                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-slate-700 text-amber-400 uppercase tracking-wider">
                            {{ auth()->user()->karyawan->peran ?? auth()->user()->role }}
                        </span>
                    @endauth
                </div>

                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-4">
                    @auth
                        @if(auth()->user()->role === 'pemilik')
                            <a href="/dashboard" class="px-3 py-2 rounded-lg text-sm font-medium hover:bg-slate-700 transition {{ request()->is('dashboard') ? 'bg-amber-500 text-slate-900 font-bold' : 'text-slate-200' }}">
                                Dashboard Penjualan
                            </a>
                        @endif

                        @if(auth()->user()->role === 'kasir')
                            <a href="/pesanan" class="px-3 py-2 rounded-lg text-sm font-medium hover:bg-slate-700 transition {{ request()->is('pesanan') ? 'bg-amber-500 text-slate-900 font-bold' : 'text-slate-200' }}">
                                Daftar Pesanan
                            </a>
                            <a href="/pesanan/create" class="px-3 py-2 rounded-lg text-sm font-medium hover:bg-slate-700 transition {{ request()->is('pesanan/create') ? 'bg-amber-500 text-slate-900 font-bold' : 'text-slate-200' }}">
                                + Buat Pesanan
                            </a>
                            <a href="/pembayaran/create" class="px-3 py-2 rounded-lg text-sm font-medium hover:bg-slate-700 transition {{ request()->is('pembayaran*') ? 'bg-amber-500 text-slate-900 font-bold' : 'text-slate-200' }}">
                                Input Pembayaran
                            </a>
                            <a href="/stok/restock" class="px-3 py-2 rounded-lg text-sm font-medium hover:bg-slate-700 transition {{ request()->is('stok/restock') ? 'bg-amber-500 text-slate-900 font-bold' : 'text-slate-200' }}">
                                Restock Bahan
                            </a>
                        @endif

                        @if(auth()->user()->role === 'koki')
                            <a href="/dapur" class="px-3 py-2 rounded-lg text-sm font-medium hover:bg-slate-700 transition {{ request()->is('dapur') ? 'bg-amber-500 text-slate-900 font-bold' : 'text-slate-200' }}">
                                Monitor Dapur
                            </a>
                        @endif

                        @if(auth()->user()->role === 'barista')
                            <a href="/bar" class="px-3 py-2 rounded-lg text-sm font-medium hover:bg-slate-700 transition {{ request()->is('bar') ? 'bg-amber-500 text-slate-900 font-bold' : 'text-slate-200' }}">
                                Monitor Bar
                            </a>
                        @endif
                    @endauth
                </div>

                <!-- User & Logout -->
                <div class="flex items-center space-x-4">
                    @auth
                        <div class="text-right text-xs">
                            <p class="font-semibold text-slate-200">{{ auth()->user()->karyawan->nama_karyawan ?? auth()->user()->username }}</p>
                            <p class="text-slate-400">@ {{ auth()->user()->username }} ({{ auth()->user()->id_user }})</p>
                        </div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="px-3 py-1.5 bg-red-600/80 hover:bg-red-600 text-white text-xs font-semibold rounded-lg transition">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 bg-amber-500 text-slate-900 text-sm font-bold rounded-lg hover:bg-amber-400 transition">
                            Login
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if(session('success'))
            <div class="mb-6 p-4 rounded-lg bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-sm font-medium">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 rounded-lg bg-red-500/10 border border-red-500/30 text-red-400 text-sm font-medium">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-800/40 border-t border-slate-800 py-4 text-center text-xs text-slate-500">
        &copy; {{ date('Y') }} Warkop Pak Yos - Sistem Pemesanan & Stok
    </footer>
</body>
</html>
