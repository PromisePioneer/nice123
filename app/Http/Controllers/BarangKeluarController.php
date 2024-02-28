<?php

namespace App\Http\Controllers;

use App\Http\Requests\BarangKeluarRequest;
use App\Http\Requests\TransaksiRequest;
use App\Models\Barang;
use App\Models\BarangKeluar;
use App\Models\Distributor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $number_page = $request->input('per_page', 10);
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

    public function distributorData()
    {
        return response()->json(Distributor::all(), 200);
    }

    public function create()
    {
        return view('pages.barang-keluar.components.create');
    }

    public function showDistributorDetail(Request $request): \Illuminate\Http\JsonResponse
    {

        $dist_id = $request->query('dist_id');
        $distributorHasBarang = Barang::with('distributor')->where('dist_id', $dist_id)->get();
        return response()->json($distributorHasBarang, 200);
    }


    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $kode = 'BG-' . Carbon::now()->format('YmdmHi-s');

        if ($request->has('dist_id')) {
            $barang_ids = $request->input('barang_id', []);
            $qty = $request->input("qty", []);
            foreach ($barang_ids as $index => $barang_id) {
                $barangs = DB::table('barang')->where('id', $barang_id)->select('barang.harga_jual')->first();

                $qtyValue = $qty[$index];
                $barangMasuk = new BarangKeluar([
                    'dist_id' => $request->dist_id,
                    'nama_customer' => $request->nama_customer,
                    'barang_id' => $barang_id,
                    'qty' => $qtyValue,
                    'no' => $kode,
                    'tanggal' => $request->tanggal,
                    'user_id' => Auth::id(),
                    'total' => $barangs->harga_jual * $qtyValue
                ]);

                $findStokBarang = DB::table('barang')->where('id', $barang_id)->get();

                foreach ($findStokBarang as $findStok) {
                    if ($findStok->stok_barang <= $qtyValue - 1) {
                        throw new \Error('Error: Insufficient stock');
                    }
                }
                $barangMasuk->save();
            }
        }

        return response()->json('test', 200);
    }

    public function edit(BarangKeluar $barangKeluar)
    {
        return view('pages.barang-keluar.components.edit', compact('barangKeluar'));
    }

    public function detail(BarangKeluar $barangKeluar)
    {
        return response()->json($barangKeluar, 200);
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

        $barang = Barang::find($barangKeluar->barang_id);
        $barang->stok_barang >= 0 ? $barang->stok_barang -= $barangKeluar->qty : $barang->stok_barang;
        $update = [
            'status' => $barangKeluar->status == 0 ? 1 : 0
        ];

        BarangKeluar::whereId($barangKeluar->id)->update($update);
        return $barang->save();
    }

    public function invoice(BarangKeluar $barangKeluar)
    {
        return view('pages.barang-keluar.components.invoice', compact('barangKeluar'));
    }
}
