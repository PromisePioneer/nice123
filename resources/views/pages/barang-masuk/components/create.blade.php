<div class="modal fade" tabindex="-1" id="modal-create">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Barang Masuk</h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-2x"></span>
                </div>
            </div>

            <div class="modal-body">
                <form id="form-create" @submit.prevent="save()">
                    <div class="row">
                            <div class="mb-10">
                                <label class="required form-label">Nama Distributor</label>
                                <select class="form-select form-select-solid" name="dist_id" x-model="selectedDistributor" x-on:change="updateDetailDistributor()">
                                    <option>-- Pilih Distributor -- </option>
                                    <template x-for="row in distributor" :key="row.id">
                                        <option :value="row.id" x-text="row.nama_distributor"></option>
                                    </template>
                                </select>
                            </div>

                            <div class="mb-10">
                                <label class="required form-label">Barang</label>
                                <select class="form-select form-select-solid" name="barang" x-on:change="updateDetailDistributor()">
                                    <option>-- Pilih Distributor -- </option>
                                    <template x-for="row in barang" :key="row.id">
                                        <option :value="row.id" x-text="row.nama"></option>
                                    </template>
                                </select>
                            </div>

                            <div x-show="selectedDistributor" class="mb-10">
                                <label class="required form-label">Harga</label>
                                <input type="text" class="form-control form-control-solid" name="harga_modal" placeholder="Additional Field"  x-model="detailDistributor.harga_modal" disabled/>
                            </div>
                            <div class="mb-10">
                                <label class="required form-label">Kuantitas</label>
                                <input type="number" class="form-control form-control-solid" name="qty" placeholder="Kuantitas"/>
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
</div>
