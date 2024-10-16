<!-- Modal -->
<div class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Admin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <form id="formAdd">
                    @csrf
                    <div class="mb-3">
                        <label for="addnama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="addnama" name="name"
                        autocomplete="off" placeholder="Nama" >
                    </div>
                    <div class="mb-3">
                        <label for="addusername" class="form-label">Username</label>
                        <input type="text" class="form-control" id="addusername" name="username"
                        autocomplete="off" placeholder="Username" >
                    </div>
                    <div class="mb-3">
                        <label for="addemail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="addemail" name="email"
                         placeholder="Email">
                    </div>
                    <div class="mb-3">
                        <label for="addpass" class="form-label">Password</label>
                        <input type="password" class="form-control" id="addpass" name="password"
                        autocomplete="off" placeholder="Password">
                    </div>

                    <button type="submit" class="btn btn-primary me-2">Simpan</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="btn-close">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
