@extends('partials._app')
@section('content')
    <div class="page-content">
        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
            <div>
                <h4 class="mb-3 mb-md-0">Kategori Buku</h4>
            </div>
            <div class="d-flex align-items-center flex-wrap text-nowrap">
                <button type="button" id="triggerModalAdd" class="btn btn-outline-primary btn-icon-text me-2 mb-2 mb-md-0">
                    <i class="btn-icon-prepend" data-feather="folder"></i> Add
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
                                    <th>NAMA</th>
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
        @includeIf('category._add')
        @includeIf('category._edit')
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
                $('#modalAdd').modal('hide');
                $('#loader-container').show();
                $.ajax({
                    url: "{{ route('category.store') }}",
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
                    url: "{{ route('category.data') }}",
                },
                columns: [
                    {data: 'DT_RowIndex', orderable: false, searchable: false,},
                    {data: 'name'},
                    { data: 'action', name: 'action', orderable: false, searchable: false,
                        render: function (data, type, row) {
                            const cid = row.id;
                            const name = row.name;
                            return `
                                <button type="button" id="edit"
                                    data-id="${cid}" data-name="${name}"
                                    class="btn btn-outline-warning btn-icon btn-xs">
                                    <i data-feather="edit-2"></i>
                                </button>
                                <button type="button" id="delete"
                                    data-id="${cid}" data-name="${name}"
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
                var cid = $(this).attr('data-id');
                var name = $(this).attr('data-name');

                $('#loader-container').show();

                $('#cid').text(cid)
                $('#category_name').text(name)

                $.ajax({
                    type: 'POST',
                    url: "{{ route('category.show') }}",
                    data: {
                        id: cid,
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
                        $('#cid').val(res.id);
                        $('#editnama').val(res.name);

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
                        url: "{{ route('category.update') }}",
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
            $('body').on('click', '#delete', function(){
                var id = $(this).attr('data-id');
                var name = $(this).attr('data-name');
                Swal.fire({
                    title: 'Akan Menghapus Kategori?',
                    text: "Kategori "+name+" Akan Terhapus !",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus!'
                }).then((value)=>{
                    if(value.isConfirmed){
                        $('#loader-container').show();
                        $.ajax({
                            url: "{{ route('category.delete') }}",
                            type: 'POST',
                            data: {
                                cid: id,
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
            $('#modalAdd').on('hidden.bs.modal', function () {
                // Kosongkan semua input dalam form
                $('#formAdd')[0].reset();
            });
            $('#modalEdit').on('hidden.bs.modal', function () {
                // Kosongkan semua input dalam form
                $('#formEdit')[0].reset();
            });
        })
    </script>
@endpush
