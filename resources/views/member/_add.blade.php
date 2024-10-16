<!-- Modal -->
<div class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Member</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <form id="formAdd">
                    @csrf
                    <div class="mb-3">
                        <label for="addnis" class="form-label">NIS</label>
                        <input type="number" class="form-control" id="addnama" name="nis"
                        autocomplete="off" placeholder="Nis" >
                    </div>
                    <div class="mb-3">
                        <label for="addnama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="addnama" name="name"
                        autocomplete="off" placeholder="Nama" >
                    </div>
                    <div class="mb-3">
                        <label for="addclass" class="form-label">Kelas</label>
                        <select class="form-select" id="addclass" name="kelas" aria-label="Kelas">
                            <option selected>Pilih Kelas</option>
                            @foreach ($kelas as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
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
