@extends('layouts.app')
@section('content')
    <div class="col-xl-12" x-data="barangMasukData">
        <div class="card card-xl-stretch mb-5 mb-xl-8">
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bolder fs-3 mb-1">Laporan Barang Masuk</span>
                </h3>
            </div>
            <div class="card-body py-3">
                <div class="float-end">
                    <input type="text" x-model="search" class="form-control form-control form-control-solid" name="search"
                        placeholder="Cari.." @input.debounce="searchData" />
                </div>
                <table class="table table-striped table-bordered gy-7 gs-7">
                    <thead>
                        <tr class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">
                            <td>No</td>
                            <td>No.Transaksi</td>
                            <td>Nama Distributor</td>
                            <td>Nama Barang</td>
                            <td>Qty</td>
                            <td>Harga</td>
                            <td>Total</td>
                            <td>User</td>
                            <td>Status</td>
                            <td>Tanggal</td>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($laporan as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->no }}</td>
                                <td>{{ $item->distributor->nama_distributor }}</td>
                                <td>{{ $item->barangs->nama }}</td>
                                <td>{{ $item->qty }}</td>
                                <td>{{ $item->barangs->harga }}</td>
                                <td>{{ $item->total }}</td>
                                <td>{{ $item->user->name }}</td>
                                <td>{{ $item->status }}</td>
                                <td>{{ $item->tanggal }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10">
                                    <p class="text-center">Data Tidak Ditemukan</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="float-end">
                    <ul class="pagination">
                        <li class="m-1 page-item previous">
                            <button @click="previousPage" class="btn btn-light btn-sm">Previous</button>
                        </li>
                        <li class="m-1 page-item next">
                            <button @click="nextPage" class="btn btn-light btn-sm">Next</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
