<!-- Modal -->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit <strong id="nama_pembina"></strong></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <form id="formEdit">
                    @csrf
                    <input type="hidden" name="pid" id="pid">
                    <input type="hidden" name="uid" id="uid">
                        <div class="mb-3">
                            <label for="edit_nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="edit_nama" name="nama_pembina"
                            autocomplete="off" placeholder="Nama" >
                        </div>
                        <div class="mb-3">
                            <label for="edit_kontak" class="form-label">Kontak</label>
                            <input type="text" class="form-control" id="edit_kontak" name="kontak"
                            autocomplete="off" placeholder="Kontak / No Tlpn">
                        </div>

                    <button type="submit" class="btn btn-primary me-2">Simpan</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="btn-close">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
