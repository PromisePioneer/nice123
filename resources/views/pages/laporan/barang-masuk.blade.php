@extends('layouts.app')
@section('content')
    <div class="col-xl-12">
        <div class="card card-xl-stretch mb-5 mb-xl-8">
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bolder fs-3 mb-1">Data Barang Keluar</span>
                </h3>
                <div class="card-toolbar">
                    <ul class="nav">
                        <li class="nav-item">
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card-body py-3">
                <div class="row">
                    <div class="col-12">
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Tanggal Awal</label>
                                    <input type="date" name="tglAwal" id="tglAwal" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Tanggal Akhir</label>
                                    <input type="date" name="tglAkhir" id="tglAkhir" class="form-control">
                                </div>
                                <a href="#"
                                    onclick="this.href='/transaksi/barang-masuk/cetak-laporan/'+ document.getElementById('tglAwal').value + '/' + document.getElementById('tglAkhir').value"
                                    class="btn btn-primary btn-sm btn-block mt-4" target="_blank">PRINT</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
