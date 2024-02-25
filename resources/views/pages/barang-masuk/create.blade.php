@extends('layouts.app')
@section('content')


    <div class="col-xl-12" x-data="createBarangMasukData">
        <div class="card card-xl-stretch mb-5 mb-xl-8">
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bolder fs-3 mb-1">Tambah Barang Masuk</span>
                </h3>
            </div>
            <div class="card-body py-3">
                <form id="form-create" @submit.prevent="save()">
                    <div class="row">
                        <div class="mb-10">
                            <label class="required form-label">Nama Distributor</label>
                            <select class="form-select form-select-solid" name="dist_id"  x-model="selectedDistributor" x-on:change="updateDetailDistributor()">
                                <option>-- Pilih Distributor -- </option>
                                <template x-for="row in distributor" :key="row.id">
                                    <option :value="row.id" x-text="row.nama_distributor"></option>
                                </template>
                            </select>
                        </div>

                        <div class="mb-10 p-lg-2 form-check form-check-solid" x-show="selectedDistributor">
                            <template x-for="(row, index) in detailDistributor" :key="row.id">
                                <div class="mb-4">
                                    <label class="form-check form-check-custom form-check-solid mb-4">
                                        <input class="form-check-input" type="checkbox" :value="row.id"/>
                                        <span class="form-check-label" x-text="`${row.nama} (Rp. ${row.harga})`"></span>
                                    </label>
                                    <input type="number" class="form-control form-control-solid" :name="'qty_' + index" :id="'qty_' + index" :placeholder="'Kuantitas ' + row.nama"/>
                                </div>
                            </template>
                        </div>


                        <div class="mb-10">
                            <label class="required form-label">Tanggal</label>
                            <input type="date" class="form-control form-control-solid" name="tanggal" placeholder="Tanggal"/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('createBarangMasukData', () =>  ({
                selectedDistributor: null,
                additionalField: '',
                detailDistributor: null,
                distributor: null,
                barang:null,
                async init(){
                    const distributor = await axios.get('/transaksi/barang-masuk/data-distributor');
                    this.distributor = distributor.data;
                },
                async updateDetailDistributor() {
                    if (this.selectedDistributor !== null) {
                        const idDistributor = Number(this.selectedDistributor);
                        const distributorInformation = await axios.get(`/transaksi/barang-masuk/showDistributorDetail?dist_id=${idDistributor}`);
                        this.detailDistributor = distributorInformation.data;
                    } else {
                        this.detailDistributor = '';
                    }
                },
            }))
        })
    </script>
@endsection
