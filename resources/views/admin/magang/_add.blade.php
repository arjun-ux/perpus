<!-- Modal -->
<div class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Magang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <form id="formAdd">
                    @csrf
                        <div class="mb-3">
                            <label for="add_tema" class="form-label">Tema Magang</label>
                            <input type="text" class="form-control bg-transparent" id="add_tema" name="tema_magang"
                            autocomplete="off" placeholder="Tema Magang" >
                        </div>
                        <div class="mb-3">
                            <label for="mulai" class="form-label">Tanggal Mulai</label>
                            <div class="input-group flatpickr  me-2 mb-2 mb-md-0 " id="dashboardDate">
                                <input type="text" class="form-control bg-transparent flatpickr-input" placeholder="Pilih Tanggal" data-input name="tgl_mulai">
                                <span class="input-group-text input-group-addon bg-transparent" data-toggle><i data-feather="calendar" class="text-primary"></i></span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="mulai" class="form-label">Tanggal Selesai</label>
                            <div class="input-group flatpickr  me-2 mb-2 mb-md-0" id="dashboardDate">
                                <input type="text" class="form-control bg-transparent flatpickr-input" placeholder="Pilih Tanggal" data-input name="tgl_selesai">
                                <span class="input-group-text input-group-addon bg-transparent" data-toggle><i data-feather="calendar" class="text-primary"></i></span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Default Status Magang Adalah <strong><i>Ongoing</i></strong></label>
                        </div>

                    <button type="submit" class="btn btn-primary me-2">Simpan</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="btn-close">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
