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
                                        <!-- Change x-model binding -->
                                        <input class="form-check-input" type="checkbox" :value="row.id" :name="'barang_id[' + index + ']'" x-model="showQtyInput[index]" @click="toggleQtyInput(index)"/>
                                        <span class="form-check-label" x-text="`${row.nama} (Rp. ${row.harga})`"></span>
                                    </label>
                                    <!-- Adjust x-show binding -->
                                    <input x-show="showQtyInput[index]" type="number" class="form-control form-control-solid" :name="'qty[' + index + ']'" :id="'qty_' + index" :placeholder="'Kuantitas ' + row.nama" x-model="barang[index].qty" />
                                </div>
                            </template>
                        </div>


                        <div class="mb-10">
                            <label class="required form-label">Tanggal</label>
                            <input type="date" class="form-control form-control-solid" name="tanggal" placeholder="Tanggal"/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a type="button" class="btn btn-light btn-sm" href="{{ url('transaksi/barang-masuk') }}">Back</a>
                        <button type="submit" class="btn btn-primary btn-sm">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const formCreate = document.getElementById('form-create');
        document.addEventListener('alpine:init', () => {
            Alpine.data('createBarangMasukData', () =>  ({
                showQtyInput: [],
                selectedDistributor: null,
                additionalField: '',
                detailDistributor: null,
                distributor: null,
                barang:null,
                async init(){
                    const distributor = await axios.get('/transaksi/barang-masuk/data-distributor');
                    this.distributor = distributor.data;
                },
                toggleQtyInput(index) {
                    // Toggle the value at the specified index
                    this.showQtyInput[index] = !this.showQtyInput[index];
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
                async save(){
                    await axios.post('/transaksi/barang-masuk', new FormData(formCreate))
                        .then(() => {
                            Swal.fire({
                                title: "Berhasil",
                                icon: "success"
                            }).then(() => {
                                window.location.href ="{{url('/transaksi/barang-masuk')}}"
                            })
                        })
                        .catch(error => {
                            const respError = error.response.data.errors;
                            Object.keys(respError).map(err => {
                                const input = formCreate.querySelector(`[name="${err}"]`);
                                input.classList.add('is-invalid');
                                if (input.nextElementSibling && input.nextElementSibling.tagName === 'SMALL') {
                                    input.nextElementSibling.textContent = respError[err][0];
                                } else {
                                    const smallElement = document.createElement('small');
                                    smallElement.classList.add('text-danger');
                                    smallElement.textContent = respError[err][0];
                                    input.insertAdjacentElement('afterend', smallElement);
                                }
                            })
                        })
                }
            }))
        })
    </script>
@endsection
