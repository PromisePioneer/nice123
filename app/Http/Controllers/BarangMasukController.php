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
        $data = BarangMasuk::with('distributor', 'user', 'barangs')->paginate($perPage);
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

    public function create()
    {
        return view('pages.barang-masuk.components.create');
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $no = 1;
        $kode = 'BG-' . Carbon::now()->format('Ymd') . '-' . $no;

        if ($request->has('dist_id')) {
            $barang_ids = $request->input('barang_id', []);
            $qty = $request->input("qty", []);
            foreach ($barang_ids as $index => $barang_id) {
                $barangs = \DB::table('barang')->where('id', $barang_id)->select('barang.harga')->first();

                $qtyValue = $qty[$index];
                $barangMasuk = new BarangMasuk([
                    'dist_id' => $request->dist_id,
                    'barang_id' => $barang_id,
                    'qty' => $qtyValue,
                    'no' => $kode,
                    'tanggal' => $request->tanggal,
                    'user_id' => Auth::id(),
                    'total' => $barangs->harga * $qtyValue
                ]);

                $findStokBarang = \DB::table('barang')->where('id', $barang_id)->get();
                foreach ($findStokBarang as $findStok){
                    \DB::table('barang')->where('id', $findStok->id)->update([
                        'stok_barang' => $findStok->stok_barang += $qtyValue
                    ]);
                }
                $barangMasuk->save();
            }
        }

        return response()->json('test', 200);
    }



    public function showDistributorDetail(Request $request): \Illuminate\Http\JsonResponse
    {

        $dist_id = $request->query('dist_id');
        $distributorHasBarang = Barang::with('distributor')->where('dist_id', $dist_id)->get();
        return response()->json($distributorHasBarang, 200);
    }

    public function edit(BarangMasuk $barangMasuk)
    {
        return view('pages.barang-masuk.components.edit', compact('barangMasuk'));
    }

    public function detail(BarangMasuk $barangMasuk)
    {
        return response()->json($barangMasuk, 200);
    }

    public function update(Request $request, BarangMasuk $barangMasuk)
    {
        if ($request->has('dist_id')) {
            $barang_ids = $request->input('barang_id', []);
            $qty = $request->input("qty", []);
            foreach ($barang_ids as $index => $barang_id) {
                $barangs = \DB::table('barang')->where('id', $barang_id)->select('harga')->first();

                $qtyValue = $qty[$index];
                $total = $barangs->harga * $qtyValue;

                $barangMasuk->where('dist_id', $request->dist_id)
                    ->where('barang_id', $barang_id)
                    ->update([
                        'qty' => $qtyValue,
                        'tanggal' => $request->tanggal,
                        'user_id' => Auth::id(),
                        'total' => $total
                    ]);

                $findStokBarang = \DB::table('barang')->where('id', $barang_id)->get();
                foreach ($findStokBarang as $findStok){
                    \DB::table('barang')->where('id', $findStok->id)->update([
                        'stok_barang' => $findStok->stok_barang + $qtyValue
                    ]);
                }
            }
        }
        return response()->json('success', 200);
    }

    public function destroy(BarangMasuk $barangMasuk)
    {
        return response()->json($barangMasuk->delete(), 200);
    }

    public function updateStatus(Request $request, BarangMasuk $barangMasuk)
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
