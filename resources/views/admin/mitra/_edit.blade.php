<!-- Modal -->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Mitra <strong id="nama_title"></strong></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <form id="formUpdate">
                    @csrf
                    <input type="hidden" name="mid" id="mid">
                        <div class="mb-3">
                            <label for="edit_nama" class="form-label">Nama Mitra</label>
                            <input type="text" class="form-control" id="edit_nama" name="nama_mitra"
                            autocomplete="off" placeholder="Nama Mitra" >
                        </div>
                        <div class="mb-3">
                            <label for="edit_alamat" class="form-label">Alamat Mitra</label>
                            <input type="text" class="form-control" id="edit_alamat" name="alamat_mitra"
                            autocomplete="off" placeholder="Alamat Mitra" >
                        </div>
                        <div class="mb-3">
                            <label for="edit_kontak" class="form-label">Kontak</label>
                            <input type="text" class="form-control" id="edit_kontak" name="kontak_mitra"
                            autocomplete="off" placeholder="Kontak / No Tlpn">
                        </div>
                        <div class="mb-3">
                            <label for="edit_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="edit_email" name="email"
                            placeholder="Email">
                        </div>

                    <button type="submit" class="btn btn-primary me-2">Simpan</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="btn-close">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
