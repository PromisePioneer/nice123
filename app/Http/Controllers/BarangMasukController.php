<?php

namespace App\Http\Controllers;

use App\Http\Requests\BarangMasukRequest;
use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\Distributor;
use Carbon\Carbon;
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
        $data = BarangMasuk::with('distributor', 'user')->paginate($perPage);
        return response()->json($data, 200);
    }

    public function barangData()
    {
        return response()->json(Barang::all(), 200);
    }

    public function distributorData()
    {
        return response()->json(Distributor::all(), 200);
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

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $no = 1;
        $kode = 'BG-' . Carbon::now()->format('Ymd') . '-' . $no;
        $barang_masuk = BarangMasuk::join('distributor', 'barang_masuk.dist_id', 'distributor.id')->select('barang_masuk.*', 'distributor.harga_modal')->first();
        $harga_modal = $barang_masuk->harga_modal;
        $total = $request->qty * $harga_modal;

        $transaksi = BarangMasuk::create([
            'no' => $kode,
            'dist_id' => $request->dist_id,
            'tanggal' => $request->tanggal,
            'qty' => $request->qty,
            'stok' => $request->stok,
            'total' => $total,
            'user_id' => Auth::id()
        ]);

        return response()->json($transaksi, 200);
    }

    public function showDistributorDetail(Distributor $distributor)
    {
        return response()->json($distributor);
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

    public function invoice(BarangMasuk $barangMasuk)
    {
        return view('pages.barang-masuk.components.invoice', compact('barangMasuk'));
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
