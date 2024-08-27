<!-- Modal -->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Program Studi <strong id="nama_title"></strong></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <form id="formUpdate">
                    @csrf
                    <input type="hidden" name="pid" id="pid">
                        <div class="mb-3">
                            <label for="edit_nama" class="form-label">Nama Program Studi</label>
                            <input type="text" class="form-control" id="edit_nama" name="nama_prodi"
                            autocomplete="off" placeholder="Nama Porgram Studi" >
                        </div>

                    <button type="submit" class="btn btn-primary me-2">Simpan</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="btn-close">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
