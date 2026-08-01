<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Pemilik\DashboardController;
use App\Http\Controllers\Kasir\PesananController;
use App\Http\Controllers\Kasir\PembayaranController;
use App\Http\Controllers\Kasir\StokController;
use App\Http\Controllers\Koki\DapurController;
use App\Http\Controllers\Barista\BarController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Authenticated Routes
Route::middleware(['auth'])->group(function () {

    // Pemilik Route
    Route::middleware(['role:pemilik'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('pemilik.dashboard');
    });

    // Kasir Routes
    Route::middleware(['role:kasir'])->group(function () {
        Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan.index');
        Route::get('/pesanan/create', [PesananController::class, 'create'])->name('pesanan.create');
        Route::post('/pesanan', [PesananController::class, 'store'])->name('pesanan.store');

        Route::get('/pembayaran/create/{id_pesanan?}', [PembayaranController::class, 'create'])->name('pembayaran.create');
        Route::post('/pembayaran', [PembayaranController::class, 'store'])->name('pembayaran.store');

        Route::get('/stok/restock', [StokController::class, 'restock'])->name('stok.restock');
        Route::post('/stok/restock', [StokController::class, 'storeRestock'])->name('stok.storeRestock');
    });

    // Koki Routes
    Route::middleware(['role:koki'])->group(function () {
        Route::get('/dapur', [DapurController::class, 'index'])->name('koki.dapur');
        Route::patch('/dapur/detail/{detailPesanan}/status', [DapurController::class, 'updateStatus'])->name('koki.updateStatus');
    });

    // Barista Routes
    Route::middleware(['role:barista'])->group(function () {
        Route::get('/bar', [BarController::class, 'index'])->name('barista.bar');
        Route::patch('/bar/detail/{detailPesanan}/status', [BarController::class, 'updateStatus'])->name('barista.updateStatus');
    });

});
