@extends('layouts.app')
@section('content')
    <div class="col-xl-12" x-data="barangMasukData">
        <div class="card card-xl-stretch mb-5 mb-xl-8">
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bolder fs-3 mb-1">Data Barang Masuk</span>
                </h3>
                <div class="card-toolbar">
                    <ul class="nav">
                        <li class="nav-item">
                            <a href="{{ url('transaksi/barang-masuk/create') }}" class="btn btn-primary btn-sm" >
                                Tambah Data
                            </a>
                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modal-laporan">
                                Print Data
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card-body py-3">
                @include('pages.barang-masuk.components.edit')
                @include('pages.barang-masuk.components.laporan')
                <div class="float-end">
                    <input type="text" x-model="search" class="form-control form-control form-control-solid" name="search" placeholder="Cari.." @input.debounce="searchData"/>
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
                        <td>Aksi</td>
                    </tr>
                    </thead>
                    <tbody>
                    <template x-if="isLoading">
                        <tr>
                            <td colspan="9">
                                <div style="text-align: center;">
                                    <div class="spinner-border" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </template>
                    <template x-if="!isLoading && barangMasuk.data?.length === 0">
                        <tr>
                            <td colspan="9">
                                <center>Data Tidak Ditemukan</center>
                            </td>
                        </tr>
                    </template>
                    <template x-for="(row,index) in barangMasuk?.data">
                        <tr>
                            <td x-text="startIndex + index++"></td>
                            <td x-text="row.no"></td>
                            <td x-text="row.distributor.nama_distributor"></td>
                            <td x-text="row.distributor.nama_barang"></td>
                            <td x-text="row.qty"></td>
                            <td x-text="row.distributor.harga_modal"></td>
                            <td x-text="row.total"></td>
                            <td>
                                <span class="badge bg-warning" x-text="row.user.name"></span>
                            </td>
                            <template x-if="row.status === 0">
                                <td>
                                    @role('owner')
                                    <button @click="updateStat(row.id)" class="badge bg-danger">Belum Disetujui</button>
                                    @endrole
                                    @role('admin')
                                    <button class="badge bg-danger">Belum Disetujui</button>
                                    @endrole
                                </td>
                            </template>
                            <template x-if="row.status === 1">
                                <td>
                                    <button type="button" class="badge bg-success">Disetujui</button>
                                </td>
                            </template>
                            <template x-if="row.status === 0">
                                <td>
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal-edit" @click="edit(row.id)">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm" @click="destroy(row.id)">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    </td>
                                </template>
                            <template x-if="row.status === 1">
                                <td>
                                    <button class="btn btn-danger btn-sm" @click="destroy(row.id)">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    <a class="btn btn-info btn-sm" :href="`/transaksi/barang-masuk/invoice/${row.id}`" >
                                        <i class="bi bi-printer"></i>
                                    </a>
                                </td>
                            </template>
                        </tr>
                    </template>
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
@push('js')
    @include('pages.barang-masuk.script')
@endpush
