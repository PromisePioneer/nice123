<?php

namespace App\Http\Controllers;

use App\Http\Requests\BarangMasukRequest;
use App\Http\Requests\TransaksiRequest;
use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BarangMasukController extends Controller
{
    public function index()
    {
        return view('pages.barang-masuk.index');
    }

    public function data(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $data = BarangMasuk::with('barang', 'user')->paginate($perPage);

        return response()->json($data, 200);
    }

    public function barangData()
    {
        return response()->json(Barang::all(), 200);
    }

    public function search(Request $request)
    {
        $search = BarangMasuk::where(function ($query) use ($request) {
                $query->orWhereHas('barang', function ($query) use ($request) {
                    $query->where('nama', 'like', '%' . $request->search . '%');
                })->orWhereHas('user', function ($query) use ($request) {
                        $query->where('name', 'like', '%' . $request->search . '%');
                })->orWhere('qty', 'like', '%' . $request->search . '%')
                    ->orWhere('harga_satuan', 'like', '%' . $request->search . '%');
            })
            ->get();

        return response()->json($search);
    }

    public function store(BarangMasukRequest $request)
    {
        $transaksi = BarangMasuk::create([
            'barang_id' => $request->barang_id,
            'tanggal' => $request->tanggal,
            'qty' => $request->qty,
            'harga_satuan' => $request->harga_satuan,
            'total' => $request->qty * $request->harga_satuan,
            'user_id' => Auth::id()
        ]);

        return response()->json($transaksi, 200);
    }

    public function edit(BarangMasuk $barangMasuk)
    {
        return response()->json($barangMasuk);
    }

    public function update(BarangMasukRequest $request, BarangMasuk $barangMasuk)
    {
        $barangMasuk->update([
            'barang_id' => $request->barang_id,
            'tanggal' => $request->tanggal,
            'qty' => $request->qty,
            'harga_satuan' => $request->harga_satuan,
            'total' => $request->qty * $request->harga_satuan,
            'type' => 'barang_masuk',
            'user_id' => Auth::id()
        ]);

        return response()->json($barangMasuk, 200);
    }

    public function destroy(BarangMasuk $barangMasuk)
    {
        return response()->json($barangMasuk->delete(), 200);
    }

    public function updateStatus(Request $request  ,BarangMasuk $barangMasuk)
    {
        $update = [
            'status' => $barangMasuk->status == 0 ? 1 : 0
        ];
        BarangMasuk::whereId($barangMasuk->id)->update($update);

        $barang = Barang::find($barangMasuk->barang_id);
        $barang->qty >= 0 ? $barang->qty -= $barangMasuk->qty : $barang->qty;
        $barang->total -= $barangMasuk->total;
        return $barang->save();
    }


    public function laporan($tglAwal, $tglAkhir)
    {
        $laporan = BarangMasuk::with('barang')
            ->where('status', 1)
            ->whereBetWeen('tanggal', [$tglAwal, $tglAkhir])
            ->get();

        return view('pages.barang-masuk.components.laporan-pdf', compact('laporan'));
    }
}
