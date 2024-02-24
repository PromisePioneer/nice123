<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function laporanBarangMasuk()
    {
        return view('pages.laporan.barang-masuk');
    }
}
