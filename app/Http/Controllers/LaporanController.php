<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangKeluar;
use App\Models\BarangMasuk;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function laporanBarangMasuk()
    {
        $barangMasuk = BarangMasuk::with('barangs')->get();

        return view('pages.laporan.barang-masuk.barang-masuk', compact('barangMasuk'));
    }

    public function laporanBarangKeluar()
    {
        $barangKeluar = BarangKeluar::with('barangs')->get();
        return view('pages.laporan.barang-keluar.barang-keluar', compact('barangKeluar'));
    }

    public function laporanBarangMasukPdf($tglAwal, $tglAkhir)
    {
        $laporan = BarangMasuk::with('barangs')
            ->where('status', 1)
            ->whereBetWeen('tanggal', [$tglAwal, $tglAkhir])
            ->get();

        $pdf = pdf::loadview('pages.laporan.barang-masuk.laporan-pdf',['laporan'=> $laporan]);
        $pdf->setPaper([0, 0, 1200, 1200]);
        return $pdf->download('laporan-barang-masuk.pdf');
    }

    public function laporanBarangMasukPdfAll()
    {
        $laporan = BarangMasuk::all();
        $pdf = pdf::loadview('pages.laporan.barang-masuk.laporan-pdf-all',['laporan'=> $laporan]);
        $pdf->setPaper([0, 0, 1200, 1200]);
        return $pdf->download('laporan-barang-masuk.pdf');
    }

    public function laporanBarangKeluarPdf($tglAwal, $tglAkhir)
    {
        $laporan = BarangKeluar::with('barangs')
            ->where('status', 1)
            ->whereBetWeen('tanggal', [$tglAwal, $tglAkhir])
            ->get();

        $pdf = pdf::loadview('pages.laporan.barang-keluar.laporan-pdf',['laporan'=> $laporan]);
        $pdf->setPaper([0, 0, 1200, 1200]);
        return $pdf->download('laporan-barang-keluar.pdf');
    }


    public function laporanBarangKeluarPdfAll()
    {
        $laporan = BarangKeluar::all();
        $pdf = pdf::loadview('pages.laporan.barang-keluar.laporan-pdf-all',['laporan'=> $laporan]);
        $pdf->setPaper([0, 0, 1200, 1200]);
        return $pdf->download('laporan-barang-keluar.pdf');
    }
}
