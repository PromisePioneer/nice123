@extends('layouts.app')
@section('content')
    <div class="col-xl-12" x-data="barangKeluarData">
        <div class="card mb-5 mb-xl-8">
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bolder fs-3 mb-1">Data Barang Keluar</span>
                </h3>
                <div class="card-toolbar">
                    <ul class="nav">
                        <li class="nav-item">
                            <a href="{{ url('/transaksi/barang-keluar/create') }}" class="btn btn-primary btn-sm">
                                Tambah Data Barang Keluar
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card-body py-3">
                <div class="float-end">
                    <input type="text" x-model="search" class="form-control form-control form-control-solid"
                           name="search" placeholder="Cari.." @input.debounce="searchData"/>
                </div>
                <table class="table table-striped gy-7 gs-7">
                    <thead>
                    <tr class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">
                        <td>No</td>
                        <td>Nama Customer</td>
                        <td>Nama Barang</td>
                        <td>Tanggal</td>
                        <td>Kuantitas</td>
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
                    <template x-if="!isLoading && barangKeluar.data?.length === 0">
                        <tr>
                            <td colspan="9">
                                <center>Data Tidak Ditemukan</center>
                            </td>
                        </tr>
                    </template>
                    <template x-for="(row,index) in barangKeluar?.data">
                        <tr>
                            <td x-text="row.no"></td>
                            <td x-text="row.nama_customer"></td>
                            <td x-text="row.barangs.nama"></td>
                            <td x-text="row.tanggal"></td>
                            <td x-text="row.qty"></td>
                            <td x-text="currency(row.barangs.harga_jual)"></td>
                            <td x-text="currency(row.total)"></td>
                            <td>
                                <span class="badge bg-warning" x-text="row.user.name"></span>
                            </td>
                            <template x-if="row.status === 0">
                                <td>
                                    <button @click="updateStat(row.id)" class="badge bg-danger">Belum Disetujui</button>
                                </td>
                            </template>
                            <template x-if="row.status === 1">
                                <td>
                                    <button type="button" class="badge bg-success">Disetujui</button>
                                </td>
                            </template>
                            <template x-if="row.status === 0">
                                <td>
                                    <a class="btn btn-primary btn-sm" :href="'/transaksi/barang-keluar/edit/' + row.id">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button class="btn btn-danger btn-sm" @click="destroy(row.id)">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </template>
                            <template x-if="row.status === 1">
                                <td>
                                    <a  class="btn btn-info btn-sm" :href="'/transaksi/barang-keluar/invoice/' + row.id">
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

        <div class="card mb-5 mb-xl-8">
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bolder fs-3 mb-1">Data Barang</span>
                </h3>
                <div class="card-toolbar">
                    <ul class="nav">
                        <li class="nav-item">
                            @role('owner')
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#modal-create">
                                Tambah Barang
                            </button>
                            @endrole
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card-body py-3">
                @include('pages.barang-keluar.record-barang-components.create')
                @include('pages.barang-keluar.record-barang-components.edit')
                <div class="float-end">
                    <input type="text" x-model="search" class="form-control form-control form-control-solid"
                           name="search" placeholder="Cari.." @input.debounce="searchData"/>
                </div>
                <table class="table table-striped gy-7 gs-7">
                    <thead>
                    <tr class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">
                        <td>No</td>
                        <td>Nama Barang</td>
                        <td>Distributor</td>
                        <td>Harga</td>
                        <td>Stok Barang</td>
                        <td>User</td>
                        <td>Status</td>
                        @role('owner')
                        <td>Aksi</td>
                        @endrole
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
                    <template x-if="!isLoading && barangData.data?.length === 0">
                        <tr>
                            <td colspan="9">
                                <center>Data Tidak Ditemukan</center>
                            </td>
                        </tr>
                    </template>
                    <template x-for="(row,index) in barangData?.data">
                        <tr>
                            <td x-text="startIndex + index++"></td>
                            <td x-text="row.nama"></td>
                            <td x-text="row.distributors.nama_distributor"></td>
                            <td x-text="currency(row.harga_jual)"></td>
                            <td x-text="row.stok_barang"></td>
                            <td x-text="row.user.name"></td>
                            <td>
                                <span class="badge bg-warning" x-text="row.user.name"></span>
                            </td>
                            @role('owner')
                            <td>
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#modal-edit" @click="editBarang(row.id)">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-danger btn-sm" @click="destroyBarang(row.id)">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                            @endrole
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
    @include('pages.barang-keluar.script')
@endpush
