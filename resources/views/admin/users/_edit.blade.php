<!-- Modal -->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit User <span id="nama_user"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <form id="formEdit">
                    <input type="hidden" name="id" id="uid">
                    <div class="mb-3">
                        <label for="editnama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="editnama" name="name"
                        autocomplete="off" placeholder="Nama" >
                    </div>
                    <div class="mb-3">
                        <label for="editusername" class="form-label">Username</label>
                        <input type="text" class="form-control" id="editusername" name="username"
                        autocomplete="off" placeholder="Username" >
                    </div>
                    <div class="mb-3">
                        <label for="editemail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="editemail" name="email"
                         placeholder="Email">
                    </div>
                    <div class="mb-3">
                        <label for="editpass" class="form-label">Password</label>
                        <input type="password" class="form-control" id="editpass" name="password"
                        autocomplete="off" placeholder="Password">
                    </div>

                    <button type="submit" class="btn btn-primary me-2">Update</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="btn-close">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
