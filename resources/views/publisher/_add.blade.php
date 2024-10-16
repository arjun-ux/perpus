<!-- Modal -->
<div class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Penerbit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <form id="formAdd">
                    @csrf
                    <div class="mb-3">
                        <label for="addnama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="addnama" name="name" required
                        autocomplete="off" placeholder="Nama" >
                    </div>
                    <div class="mb-3">
                        <label for="add_addres" class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="add_addres" name="address"
                        autocomplete="off" placeholder="Alamat" >
                    </div>
                    <div class="mb-3">
                        <label for="addphone" class="form-label">No Tlpn</label>
                        <input type="number" class="form-control" id="addphone" name="phone"
                        autocomplete="off" placeholder="No Tlpn" >
                    </div>
                    <div class="mb-3">
                        <label for="addemail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="addemail" name="email"
                        autocomplete="off" placeholder="Email" >
                    </div>
                    <div class="mb-3">
                        <label for="addweb" class="form-label">Website</label>
                        <input type="text" class="form-control" id="addweb" name="website"
                        autocomplete="off" placeholder="Website" >
                    </div>
                    <div class="mb-3">
                        <label for="addestablished_year" class="form-label">Tahun Berdiri</label>
                        <input type="date" class="form-control" id="addestablished_year" name="established_year"
                        autocomplete="off" placeholder="Tahun Berdiri" >
                    </div>

                    <button type="submit" class="btn btn-primary me-2">Simpan</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="btn-close">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
