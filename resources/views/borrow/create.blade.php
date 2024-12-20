@extends('partials._app')
@section('content')
    <div class="page-content">
        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
            <div>
                <h4 class="mb-3 mb-md-0">Peminjaman</h4>
            </div>
            <div class="d-flex align-items-center flex-wrap text-nowrap">

            </div>
        </div>
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <form id="formAdd">
                                @csrf
                                <div class="mb-3">
									<label class="form-label">PILIH NIS</label>
									<select class="js-example-basic-single form-select select2"
                                        id="addIdMember" name="username" required data-width="100%">
										<option value="" disabled selected>PILIH NIS</option>
									</select>
								</div>
                                <div class="mb-3">
									<label class="form-label">Pilih Buku</label>
									<select class="js-example-basic-single form-select select2"
                                        id="addIdbook" name="book_id" required data-width="100%">
										<option value="" disabled selected>Pilih Buku</option>
									</select>
								</div>
                                <div class="mb-3">
                                    <label for="addkondisi" class="form-label">KONDISI</label>
                                    <select name="condition" id="addkondisi" class="form-select" required>
                                        <option value="">Pilih Kondisi</option>
                                        <option value="Baik">Baik</option>
                                        <option value="Rusak">Rusak</option>
                                    </select>
                                </div>

                                <div class="mb-3" id="btnsave" style="display: none">
                                    <button type="submit" class="form-control btn btn-outline-success btn-icon-text me-2 mb-2 mb-md-0">
                                        <i class="btn-icon-prepend" data-feather="book-open"></i> Pinjam
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">NOMOR INDUK SISWA (NIS)</label>
                                <h5 id="member_id"></h5>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">NAMA SISWA</label>
                                <h5 id="member_name"></h5>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">KELAS</label>
                                <h5 id="member_kls"></h5>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">PEMINJAMAN SEBELUMNYA</label>
                                <h5 id="peminjaman_sebelumnya"></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 grid-margin stretch-card" id="cardbook" style="display: none">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">JUDUL BUKU</label>
                                <h5 id="title"></h5>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">PENULIS</label>
                                <h5 id="author"></h5>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">STOK BUKU</label>
                                <h5 id="stok_buku"></h5>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">STOK BAIK</label>
                                <h5 id="stok_baik"></h5>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">STOK RUSAK</label>
                                <h5 id="stok_rusak"></h5>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <img src="{{ asset('assets/images/logo.png') }}" alt="Buku" class="img-fluid" width="200px">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        $(document).ready(function(){

            $('#addIdMember').select2({
                ajax: {
                    url: "{{ route('getMember') }}",
                    dataType: 'json',
                    delay: 250, // Mengurangi jumlah request
                    data: function (params) {
                        return {
                            q: params.term, // Mengambil kata kunci dari input
                            page: params.page || 1 // Mengambil halaman saat ini
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.data.map(function(member) {
                                return {
                                    id: member.username,
                                    text: member.username,
                                };
                            }),
                            pagination: {
                                more: data.current_page < data.last_page
                            }
                        };
                    }
                },
                minimumInputLength: 1
            });
            $('#addIdMember').on('select2:select', function (e) {
                var data = e.params.data;

                $.ajax({
                    url: "{{ route('cek_member_borrowing') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        username: data.text,
                    },
                    success: function(res){
                        console.log(res)
                        $('#loader-container').hide()
                        $('#member_id').text(res.user.username)
                        $('#member_name').text(res.user.name)
                        $('#member_kls').text(res.kelas.name)

                        if(res.last_borrow.length == 0){
                            $('#peminjaman_sebelumnya').html('<span class="badge bg-success">Tidak ada pinjaman.</span>');
                        }else if(res.last_borrow.status == 'Selesai'){
                            $('#peminjaman_sebelumnya').html('<span class="badge bg-success">Tidak ada pinjaman.</span>');
                        }else{
                            $('#peminjaman_sebelumnya').html('<span class="badge bg-danger">Masih Memiliki Pinjaman Buku</span>');
                        }
                    },
                    error: function(xhr, error){
                        $('#loader-container').hide()
                        if (xhr.status === 404) {
                            toastr.error(xhr.responseJSON.message);
                        } else {
                            let errorMessages = xhr.responseJSON.errors;
                            if (errorMessages) {
                                Object.keys(errorMessages).forEach((key) => {
                                    errorMessages[key].forEach((errorMessage) => {
                                        toastr.error(errorMessage);
                                    });
                                });
                            } else {
                                toastr.error('Terjadi kesalahan: ' + xhr.status + ' ' + xhr.statusText);
                            }
                        }
                    }
                });
            });

            $('#addIdbook').select2({
                ajax: {
                    url: "{{ route('getBooks') }}",
                    dataType: 'json',
                    delay: 250, // Mengurangi jumlah request
                    data: function (params) {
                        return {
                            q: params.term, // Mengambil kata kunci dari input
                            page: params.page || 1 // Mengambil halaman saat ini
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.data.map(function(book) {
                                return {
                                    id: book.id,
                                    text: book.title,
                                    author: book.author, // Tambahkan properti author
                                    stok: book.stock, // Tambahkan properti stok
                                    stok_baik: book.stock_baik, // Tambahkan properti stok_baik
                                    stok_rusak: book.stock_rusak
                                };
                            }),
                            pagination: {
                                more: data.current_page < data.last_page
                            }
                        };
                    }
                },
                minimumInputLength: 3
            });
            $('#addIdbook').on('select2:select', function (e) {
                var data = e.params.data;

                $('#title').text(data.text);
                $('#author').text(data.author);
                $('#stok_buku').text(data.stok);
                $('#stok_baik').text(data.stok_baik);
                $('#stok_rusak').text(data.stok_rusak);
            });




            // Menangani pilihan buku
            $('#addkondisi').on('change', function() {

                $('#btnsave').show();
                $('#cardbook').show();
            });

            $('#formAdd').submit(function(e){
                e.preventDefault();
                $('#loader-container').show();
                $.ajax({
                    url: "{{ route('borrow.store') }}",
                    method: 'POST',
                    data: $('#formAdd').serialize(),
                    success: function(res){
                        $('#loader-container').hide();
                        Swal.fire({
                            title: res.message,
                            icon: 'success',
                            toast: true,
                            timer: 1000,
                            position: 'top-end',
                            showConfirmButton: false,
                            timerProgressBar: true,
                        });
                        window.location.reload();
                    },
                    error: function(xhr, error){
                        $('#loader-container').hide();
                        if (xhr.status === 404) {
                            toastr.error(xhr.responseJSON.message);
                        } else {
                            let errorMessages = xhr.responseJSON.errors;
                            if (errorMessages) {
                                Object.keys(errorMessages).forEach((key) => {
                                    errorMessages[key].forEach((errorMessage) => {
                                        toastr.error(errorMessage);
                                    });
                                });
                            } else {
                                toastr.error('Terjadi kesalahan: ' + xhr.status + ' ' + xhr.statusText);
                            }
                        }
                    }
                });
            })
        })
    </script>
@endpush
