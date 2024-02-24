<?php

namespace App\Http\Controllers;

use App\Models\BarangKeluar;
use App\Models\BarangMasuk;
use App\Models\Distributor;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $distributor = Distributor::count();
        $barang_masuk = BarangMasuk::count();
        $barang_keluar = BarangKeluar::count();
        return view('home', compact('distributor','barang_masuk', 'barang_keluar'));
    }
}
