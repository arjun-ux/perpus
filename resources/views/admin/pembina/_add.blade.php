<!-- Modal -->
<div class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Pembina</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <form id="formAdd">
                    @csrf
                        <div class="mb-3">
                            <label for="add_nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="add_nama" name="nama_pembina"
                            autocomplete="off" placeholder="Nama" >
                        </div>
                        <div class="mb-3">
                            <label for="add_username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="add_username" name="username"
                            autocomplete="off" placeholder="Username" >
                        </div>
                        <div class="mb-3">
                            <label for="add_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="add_email" name="email"
                            placeholder="Email">
                        </div>
                        <div class="mb-3">
                            <label for="add_kontak" class="form-label">Kontak</label>
                            <input type="text" class="form-control" id="add_kontak" name="kontak"
                            autocomplete="off" placeholder="Kontak / No Tlpn">
                        </div>

                    <button type="submit" class="btn btn-primary me-2">Simpan</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="btn-close">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
