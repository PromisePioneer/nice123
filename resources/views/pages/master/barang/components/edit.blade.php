<div class="modal fade" tabindex="-1" id="modal-edit">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Barang</h5>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-2x"></span>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
                <form id="form-edit" @submit.prevent="update(barangId)">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-10">
                                <label class="required form-label">Nama</label>
                                <input type="text" class="form-control form-control-solid" name="nama" placeholder="Nama barang" :value="editVal.nama"/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-10">
                                <label class="required form-label">Distributor</label>
                                <select class="form-select form-select-solid"
                                        name="dist_id">
                                    <option>-- Pilih Distributor --</option>
                                    <template x-for="row in distributor" :key="row.id" >
                                        <option :value="row.id" x-text="row.nama_distributor" :selected="row.id == editVal.dist_id"></option>
                                    </template>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-10">
                                <label class="required form-label">Stok</label>
                                <input type="number" :value="editVal.stok_barang" class="form-control form-control-solid" name="stok_barang" placeholder="stok" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-10">
                                <label class="required form-label">Harga</label>
                                <input type="number" :value="editVal.harga" class="form-control form-control-solid" name="harga" placeholder="Harga"/>
                            </div>
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
