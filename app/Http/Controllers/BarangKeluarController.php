<?php

namespace App\Http\Controllers;

use App\Http\Requests\BarangKeluarRequest;
use App\Http\Requests\TransaksiRequest;
use App\Models\Barang;
use App\Models\BarangKeluar;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BarangKeluarController extends Controller
{
    public function index()
    {
        return view('pages.barang-keluar.index');
    }

    public function dataBarang()
    {
        return response()->json(Barang::all());
    }

    public function data(Request $request)
    {
        $number_page = $request->input('per_page' , 10);
        $barang_keluar = BarangKeluar::with('user.roles', 'barang')->paginate($number_page);

        return response()->json($barang_keluar);
    }

    public function search(Request $request)
    {
        $search = BarangKeluar::where(function ($query) use ($request) {
                $query->orWhereHas('barang', function ($query) use ($request) {
                    $query->where('nama', 'like', '%' . $request->search . '%');
                })->orWhereHas('user', function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->search . '%');
                })->orWhere('qty', 'like', '%' . $request->search . '%')
                    ->orWhere('harga_satuan', 'like', '%' . $request->search . '%');
            })->get();

        return response()->json($search);
    }

    public function barangData()
    {
        return response()->json(Barang::all(), 200);
    }

    public function store(BarangKeluarRequest $request)
    {
        $barang_keluar = BarangKeluar::create([
            'barang_id' => $request->barang_id,
            'qty' => $request->qty,
            'harga_satuan' => $request->harga_satuan,
            'total' => $request->qty * $request->harga_satuan,
            'tanggal' => $request->tanggal,
            'user_id' => Auth::id()
        ]);

        return response()->json($barang_keluar, 200);
    }

    public function edit(BarangKeluar $barangKeluar)
    {
        return response()->json($barangKeluar);
    }

    public function update(BarangKeluarRequest $request, BarangKeluar $barangKeluar)
    {
        $barangKeluar->update([
            'barang_id' => $request->barang_id,
            'qty' => $request->qty,
            'harga_satuan' => $request->harga_satuan,
            'total' => $request->qty * $request->harga_satuan,
            'tanggal' => $request->tanggal,
            'user_id' => Auth::id()
        ]);

        return response()->json($barangKeluar, 200);
    }

    public function destroy(BarangKeluar $barangKeluar)
    {
        return response()->json($barangKeluar->delete(), 200);
    }


    public function updateStatus(BarangKeluar $barangKeluar)
    {
        $update = [
            'status' => $barangKeluar->status == 0 ? 1 : 0
        ];

        BarangKeluar::whereId($barangKeluar->id)->update($update);

        $barang = Barang::find($barangKeluar->barang_id);
        $barang->qty >= 0 ? $barang->qty -= $barangKeluar->qty : $barang->qty;
        $barang->total -= $barangKeluar->total;
        return $barang->save();
    }

    public function laporan($tglAwal, $tglAkhir)
    {
        $laporan = BarangKeluar::with('barang')
            ->where('status', 1)
            ->whereBetWeen('tanggal', [$tglAwal, $tglAkhir])
            ->get();



        return view('pages.barang-keluar.components.laporan-pdf', compact('laporan'));
    }
}
