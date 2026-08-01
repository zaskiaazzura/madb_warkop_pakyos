<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $laporan = DB::table('v_laporan_penjualan_harian')->get();
        return view('pemilik.dashboard', compact('laporan'));
    }
}
