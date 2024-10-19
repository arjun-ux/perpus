<!-- Modal -->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Penerbit <span id="name_user"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <form id="formEdit">
                    @csrf
                    <input type="hidden" name="pid" id="pid">
                    <div class="mb-3">
                        <label for="editnama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="editnama" name="name" required
                        autocomplete="off" placeholder="Nama" >
                    </div>
                    <div class="mb-3">
                        <label for="editaddres" class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="editaddres" name="address"
                        autocomplete="off" placeholder="Alamat" >
                    </div>
                    <div class="mb-3">
                        <label for="editphone" class="form-label">No Tlpn</label>
                        <input type="number" class="form-control" id="editphone" name="phone"
                        autocomplete="off" placeholder="No Tlpn" >
                    </div>
                    <div class="mb-3">
                        <label for="editemail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="editemail" name="email"
                        autocomplete="off" placeholder="Email" >
                    </div>
                    <div class="mb-3">
                        <label for="editweb" class="form-label">Website</label>
                        <input type="text" class="form-control" id="editweb" name="website"
                        autocomplete="off" placeholder="Website" >
                    </div>
                    <div class="mb-3">
                        <label for="editestablished_year" class="form-label">Tahun Berdiri</label>
                        <input type="date" class="form-control" id="editestablished_year" name="established_year"
                        autocomplete="off" placeholder="Tahun Berdiri" >
                    </div>

                    <button type="submit" class="btn btn-primary me-2">Simpan</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="btn-close">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
