<!-- Modal -->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Buku <span id="nama_buku"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <form id="formEdit">
                    @csrf
                    <input type="hidden" name="bid" id="bid">
                    <div class="mb-3">
                        <label for="edittitle" class="form-label">Judul Buku</label>
                        <input type="text" class="form-control" id="edittitle" name="title"
                        autocomplete="off" required placeholder="Judul Buku" >
                    </div>
                    <div class="mb-3">
                        <label for="editauthor" class="form-label">Penulis Buku</label>
                        <input type="text" class="form-control" id="editauthor" name="author"
                        autocomplete="off" required placeholder="Penulis Buku" >
                    </div>
                    <div class="mb-3">
                        <label for="editpublisher" class="form-label">Penerbit</label>
                        <select class="form-select" id="editpublisher" name="publisher_id" aria-label="Penerbit">
                            <option selected>Pilih Penerbit</option>
                            @foreach ($publishers as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                            <!-- Tambahkan lebih banyak opsi sesuai kebutuhan -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editcat" class="form-label">Kategori</label>
                        <select class="form-select" id="editcat" name="category_id" aria-label="Penerbit">
                            <option selected>Pilih Kategori Buku</option>
                            @foreach ($categorys as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                            <!-- Tambahkan lebih banyak opsi sesuai kebutuhan -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editisbn" class="form-label">ISBN</label>
                        <input type="text" class="form-control" id="editisbn" name="isbn"
                        autocomplete="off" required placeholder="ISBN" >
                    </div>
                    <div class="mb-3">
                        <label for="editpublish" class="form-label">Tahun Terbit</label>
                        <input type="date" class="form-control" id="editpublish" name="publish_date"
                        autocomplete="off" required placeholder="Tahun Terbit" >
                    </div>
                    <div class="mb-3">
                        <label for="editrusak" class="form-label">Stok Rusak</label>
                        <input type="number" class="form-control" id="editrusak" name="stock_rusak"
                        autocomplete="off" required placeholder="Stok Rusak" >
                    </div>
                    <div class="mb-3">
                        <label for="editstock" class="form-label">Stok Baik</label>
                        <input type="number" class="form-control" id="editstock" name="stock_baik"
                        autocomplete="off" required placeholder="Stok Baik" >
                    </div>

                    <button type="submit" class="btn btn-primary me-2">Simpan</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="btn-close">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
