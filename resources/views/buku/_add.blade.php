<!-- Modal -->
<div class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Buku</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <form id="formAdd">
                    @csrf
                    <div class="mb-3">
                        <label for="addtitle" class="form-label">Judul Buku</label>
                        <input type="text" class="form-control" id="addtitle" name="title"
                        autocomplete="off" required placeholder="Judul Buku" >
                    </div>
                    <div class="mb-3">
                        <label for="addauthor" class="form-label">Penulis Buku</label>
                        <input type="text" class="form-control" id="addauthor" name="author"
                        autocomplete="off" required placeholder="Penulis Buku" >
                    </div>
                    <div class="mb-3">
                        <label for="addpublisher" class="form-label">Penerbit</label>
                        <select class="form-select" id="addpublisher" name="publisher_id" aria-label="Penerbit">
                            <option selected>Pilih Penerbit</option>
                            @foreach ($publishers as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                            <!-- Tambahkan lebih banyak opsi sesuai kebutuhan -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="addcat" class="form-label">Kategori</label>
                        <select class="form-select" id="addcat" name="category_id" aria-label="Penerbit">
                            <option selected>Pilih Kategori Buku</option>
                            @foreach ($categorys as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                            <!-- Tambahkan lebih banyak opsi sesuai kebutuhan -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="addisbn" class="form-label">ISBN</label>
                        <input type="text" class="form-control" id="addisbn" name="isbn"
                        autocomplete="off" required placeholder="ISBN" >
                    </div>
                    <div class="mb-3">
                        <label for="addpublish" class="form-label">Tahun Terbit</label>
                        <input type="date" class="form-control" id="addpublish" name="publish_date"
                        autocomplete="off" required placeholder="Tahun Terbit" >
                    </div>
                    <div class="mb-3">
                        <label for="addstock_" class="form-label">Stok Rusak</label>
                        <input type="number" class="form-control" id="addstock_" name="stock_rusak"
                        autocomplete="off" required placeholder="Stok Rusak" >
                    </div>
                    <div class="mb-3">
                        <label for="addstock" class="form-label">Stok Baik</label>
                        <input type="number" class="form-control" id="addstock" name="stock_baik"
                        autocomplete="off" required placeholder="Stok Baik" >
                    </div>

                    <button type="submit" class="btn btn-primary me-2">Simpan</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="btn-close">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
