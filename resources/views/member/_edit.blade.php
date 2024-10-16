<!-- Modal -->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Member <span id="member_name"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <form id="formEdit">
                    @csrf
                    <input type="hidden" id="uid" name="uid">
                    <div class="mb-3">
                        <label for="editusername" class="form-label">Nis</label>
                        <input type="text" class="form-control" id="editusername" name="username"
                        autocomplete="off" placeholder="Nis" >
                    </div>
                    <div class="mb-3">
                        <label for="editnama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="editnama" name="name"
                        autocomplete="off" placeholder="Nama" >
                    </div>
                    <div class="mb-3">
                        <label for="editclass" class="form-label">Kelas</label>
                        <select class="form-select" id="editclass" name="kelas" aria-label="Kelas">
                            <option selected>Pilih Kelas</option>
                            @foreach ($kelas as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                            <!-- Tambahkan lebih banyak opsi sesuai kebutuhan -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editstts" class="form-label">Status Anggota</label>
                        <select class="form-select" id="editstts" name="status" aria-label="status">
                            <option selected>Pilih Kelas</option>
                            <option value="Active">Active</option>
                            <option value="Non-Active">Non-Active</option>
                            <!-- Tambahkan lebih banyak opsi sesuai kebutuhan -->
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary me-2">Simpan</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="btn-close">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
