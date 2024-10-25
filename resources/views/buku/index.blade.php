@extends('partials._app')
@section('content')
    <div class="page-content">
        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
            <div>
                <h4 class="mb-3 mb-md-0">Data Buku</h4>
            </div>
            <div class="d-flex align-items-center flex-wrap text-nowrap">
                <button type="button" id="triggerModalAdd" class="btn btn-outline-primary btn-icon-text me-2 mb-2 mb-md-0">
                    <i class="btn-icon-prepend" data-feather="book-open"></i> Add
                </button>
            </div>
        </div>
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="tbl_user" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>JUDUL</th>
                                    <th>PENULIS</th>
                                    <th>PENERBIT</th>
                                    <th>BUKU BAIK</th>
                                    <th>BUKU RUSAK</th>
                                    <th>STOK BUKU</th>
                                    <th>JUMLAH BUKU</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @includeIf('buku._add')
        @includeIf('buku._edit')
    </div>
@endsection
@push('script')
    <script>
        $(document).ready(function(){
            $('#triggerModalAdd').click(function(){
                $('#modalAdd').modal('show');
            });

            $('#formAdd').submit(function(e){
                e.preventDefault();
                $('#loader-container').show();
                $('#modalAdd').modal('hide');
                $.ajax({
                    url: "{{ route('book.store') }}",
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
                        $('#tbl_user').DataTable().ajax.reload();
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


            $('#tbl_user').DataTable({
                processing: false,
                serverSide: true,
                ajax: {
                    url: "{{ route('books.data') }}",
                },
                columns: [
                    {data: 'DT_RowIndex', orderable: false, searchable: false,},
                    {data: 'title'},
                    {data: 'author'},
                    {data: 'penerbit'},
                    {data: 'stock_baik'},
                    {data: 'stock_rusak'},
                    {data: 'stock'},
                    {data: 'jumlah_buku'},
                    {data: 'action', name: 'action', orderable: false, searchable: false,
                        render: function (data, type, row) {
                            const bid = row.id;
                            const name = row.title;
                            return `
                                <button type="button" id="edit"
                                    data-id="${bid}" data-name="${name}"
                                    class="btn btn-outline-warning btn-icon btn-xs">
                                    <i data-feather="edit-2"></i>
                                </button>
                                <button type="button" id="delete"
                                    data-id="${bid}" data-name="${name}"
                                    class="btn btn-outline-danger btn-icon btn-xs">
                                    <i data-feather="trash-2" ></i>
                                </button>
                            `;
                        }
                    }
                ],
                drawCallback: function() {
                    feather.replace();
                }
            });
            $('body').on('click', '#edit', function(){
                var bid = $(this).attr('data-id');
                var name = $(this).attr('data-name');

                $('#bid').text(bid)
                $('#nama_buku').text(name)

                $('#loader-container').show();
                $.ajax({
                    type: 'POST',
                    url: "{{ route('book.show') }}",
                    data: {
                        bid: bid,
                        _token: "{{ csrf_token() }}",
                    },
                    success: function(res){
                        $('#loader-container').hide();
                        if (res.status === 404){
                            Swal.fire({
                                title: res.message,
                                icon: 'error',
                                toast: true,
                                timer: 1000,
                                position: 'top-end',
                                showConfirmButton: false,
                                timerProgressBar: true,
                            });
                        }

                        $('#bid').val(res.id);
                        $('#edittitle').val(res.title);
                        $('#editauthor').val(res.author);
                        $('#editpublisher').val(res.publisher_id);
                        $('#editcat').val(res.category_id);
                        $('#editisbn').val(res.isbn);
                        $('#editpublish').val(res.publish_date);
                        $('#editrusak').val(res.stock_rusak);
                        $('#editstock').val(res.stock_baik);

                        $('#modalEdit').modal('show');

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
                })
                $('#formEdit').submit(function(e){
                    e.preventDefault();
                    $('#loader-container').show();
                    var formData = $(this).serialize();
                    $('#modalEdit').modal('hide');
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('books.update') }}",
                        data: formData + '&_token={{ csrf_token() }}',
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
                            }).then(()=>{
                                $('#tbl_user').DataTable().ajax.reload();
                            })
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
                    })
                })
            })
            $('#modalEdit').on('hide.bs.modal', function(){
                var form = document.getElementById('formEdit');
                if (form) {
                    form.reset();
                }
            })
            $('body').on('click', '#delete', function(){
                var id = $(this).attr('data-id');
                var name = $(this).attr('data-name');
                Swal.fire({
                    title: 'Akan Menghapus Buku?',
                    text: "Buku "+name+" Akan Terhapus !",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus!'
                }).then((value)=>{
                    if(value.isConfirmed){
                        $('#loader-container').show();
                        $.ajax({
                            url: "{{ route('book.delete') }}",
                            type: 'POST',
                            data: {
                                bid: id,
                                _token: '{{ csrf_token() }}',
                            },
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
                                }).then(()=>{
                                    $('#tbl_user').DataTable().ajax.reload();
                                });
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
                        })
                    }
                    return;
                });
            });
        })
    </script>
@endpush
