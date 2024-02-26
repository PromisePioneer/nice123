<?php

namespace App\Http\Controllers;

use App\Models\BarangKeluar;
use App\Models\BarangMasuk;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function laporanBarangMasuk()
    {
        $barangMasuk = BarangMasuk::with('barangs')->get();

        return view('pages.laporan.barang-masuk', compact('barangMasuk'));
    }

    public function laporanBarangKeluar()
    {
        $barangKeluar = BarangKeluar::with('barangs')->get();
        return view('pages.laporan.barang-keluar', compact('barangKeluar'));
    }
}
