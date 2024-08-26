<!-- Modal -->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit <strong id="nama_title"></strong></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <form id="formUpdate">
                    @csrf
                    <input type="hidden" name="mid" id="mid">
                        <div class="mb-3">
                            <label for="edit_tema" class="form-label">Tema Magang</label>
                            <input type="text" class="form-control bg-transparent" id="edit_tema" name="tema_magang"
                            autocomplete="off" placeholder="Tema Magang" >
                        </div>
                        <div class="mb-3">
                            <label for="mulai" class="form-label">Tanggal Mulai</label>
                            <div class="input-group flatpickr  me-2 mb-2 mb-md-0 " id="dashboardDate">
                                <input type="text" class="form-control bg-transparent flatpickr-input" placeholder="Pilih Tanggal" data-input name="tgl_mulai" id="edit_mulai">
                                <span class="input-group-text input-group-addon bg-transparent" data-toggle><i data-feather="calendar" class="text-primary"></i></span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="mulai" class="form-label">Tanggal Selesai</label>
                            <div class="input-group flatpickr  me-2 mb-2 mb-md-0" id="dashboardDate">
                                <input type="text" class="form-control bg-transparent flatpickr-input" placeholder="Pilih Tanggal" data-input name="tgl_selesai" id="edit_selesai">
                                <span class="input-group-text input-group-addon bg-transparent" data-toggle><i data-feather="calendar" class="text-primary"></i></span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="stts" class="form-label">Status</label>
                            <select class="form-select" name="stts_magang" id="stts">
                                <option selected disabled>Pilih Status</option>
                                <option value="Ongoing">Ongoing</option>
                                <option value="Mulai">Mulai</option>
                                <option value="Selesai">Selesai</option>
                            </select>
                        </div>

                    <button type="submit" class="btn btn-primary me-2">Simpan</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="btn-close">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
