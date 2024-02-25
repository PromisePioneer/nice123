@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-body p-lg-20">
            <div class="d-flex flex-column flex-xl-row">
                <div class="flex-lg-row-fluid me-xl-18 mb-10 mb-xl-0">
                    <div class="mt-n1">
                        <div class="d-flex flex-stack pb-10">
                            <a href="#">
                                <img alt="Logo" src="{{ asset('assets/logo.png') }}" width="100" height="100"/>
                            </a>

                        </div>
                        <div class="m-0">
                            <div class="fw-bolder fs-3 text-gray-800 mb-8">INVOICE {{ $barangMasuk->no }}</div>
                            <div class="row g-5 mb-11">
                                <div class="col-sm-6">
                                    <div class="fw-bold fs-7 text-gray-600 mb-1">Tanggal</div>
                                    <div class="fw-bolder fs-6 text-gray-800">{{ $barangMasuk->created_at->format('d M, Y') }}</div>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <div class="table-responsive border-bottom mb-9">
                                    <table class="table mb-3">
                                        <thead>
                                        <tr class="border-bottom fs-6 fw-bolder text-muted">
                                            <th class="min-w-175px pb-2">Nama Barang</th>
                                            <th class="min-w-70px text-end pb-2">Kuantitas</th>
                                            <th class="min-w-70px text-end pb-2">Harga</th>
                                            <th class="min-w-100px text-end pb-2">Total</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr class="fw-bolder text-gray-700 fs-5 text-end">
                                            <td class="d-flex align-items-center pt-6">
                                                <i class="fa fa-genderless text-danger fs-2 me-2 text-capitalize"></i>{{ $barangMasuk->barangs->nama }}</td>
                                            <td class="pt-6">{{ $barangMasuk->qty }}</td>
                                            <td class="pt-6">Rp.{{ number_format($barangMasuk->barangs->harga) }}</td>
                                            <td class="pt-6 text-dark fw-boldest">Rp.{{ number_format($barangMasuk->total) }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="m-0">
                    <div class="d-print-none border border-dashed border-gray-300 card-rounded h-lg-100 min-w-md-350px p-9 bg-lighten">
                        <div class="mb-8">
                            @if($barangMasuk->status === 0)
                            <span class="badge badge-light-warning">Pending</span>
                            @else
                            <span class="badge badge-light-success me-2">Approved</span>
                            @endif
                        </div>
                        <h6 class="mb-8 fw-boldest text-gray-600 text-hover-primary">Distributor Detail</h6>
                        <div class="mb-6">
                            <div class="fw-bold text-gray-600 fs-7">Nama : </div>
                            <div class="fw-bolder text-gray-800 fs-6">{{ $barangMasuk->distributor->nama_distributor }}</div>
                        </div>
                        <div class="mb-6">
                            <div class="fw-bold text-gray-600 fs-7">NO Transaksi : </div>
                            <div class="fw-bolder text-gray-800 fs-6">{{ $barangMasuk->no }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
