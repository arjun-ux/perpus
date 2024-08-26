@extends('partials._app')
@section('content')
    <div class="page-content">
        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
            <div>
                <h4 class="mb-3 mb-md-0">Data Asrama</h4>
            </div>
            <div class="d-flex align-items-center flex-wrap text-nowrap">
                <button type="button" id="tambahAsrama" class="btn btn-outline-primary btn-sm btn-icon-text me-2 mb-2 mb-md-0">
                    <i class="btn-icon-prepend" data-feather="user-plus"></i> Asrama
                </button>
            </div>
        </div>
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="tbl_asrama" style="width: 100%;">
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
        @includeIf('admin.asrama._add')
        @includeIf('admin.asrama._edit')
    </div>
@endsection
@push('script')
    <script>
        $(document).ready(function(){
            $('#tbl_asrama').DataTable({
                processing: false,
                serverSide: true,
                ajax: {
                    url: "{{ route('asrama.data') }}",
                    type: "GET",
                },
                columns: [
                    {data: 'DT_RowIndex',orderable: false, searchable: false},
                    {data: 'nama_asrama'},
                    { data: 'action', name: 'action', orderable: false, searchable: false,
                        render: function (data, type, row) {
                            const mid = row.id;
                            const nama = row.nama_asrama;
                            return `
                                <button type="button" id="edit"
                                    data-id="${mid}" data-name="${nama}"
                                    class="btn btn-outline-warning btn-icon btn-xs">
                                    <i data-feather="edit-2"></i>
                                </button>
                                <button type="button" id="delete"
                                    data-id="${mid}" data-name="${nama}"
                                    class="btn btn-outline-danger btn-icon btn-xs">
                                    <i data-feather="trash-2" class="icon-sm"></i>
                                </button>
                            `;
                        }
                    }
                ],
                drawCallback: function() {
                    feather.replace();
                }
            });

            $('#tambahAsrama').click(function(){
                $('#modalAdd').modal('show');
            })
            $('#formAdd').submit(function(e){
                e.preventDefault();
                $.ajax({
                    url: "{{ route('asrama.store') }}",
                    type: "POST",
                    data: $('#formAdd').serialize(),
                    success: function(res){
                        $('#modalAdd').modal('hide');
                        Swal.fire({
                            title: res.message,
                            icon: 'success',
                            toast: true,
                            timer: 1300,
                            position: 'top-end',
                            showConfirmButton: false,
                            timerProgressBar: true,
                        }).then(()=>{
                            $('#tbl_asrama').DataTable().ajax.reload();
                        });
                    },
                    error: function(xhr, error){
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
                                toastr.error('Maaf Terjadi kesalahan Internal...');
                            }
                        }
                    }
                })
            })

            $('body').on('click','#edit', function(){
                var id = $(this).attr('data-id');
                var title = $(this).attr('data-name');
                $('#nama_title').text(title);
                $.ajax({
                    url: "{{ route('asrama.id') }}",
                    type: "post",
                    data: {
                        aid:id,
                        _token: "{{ csrf_token() }}",
                    },
                    success: function(res){
                        $('#aid').val(res.id);
                        $('#edit_nama').val(res.nama_asrama);
                        $('#modalEdit').modal('show');
                    },
                    error: function(xhr, error){
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
                                toastr.error('Maaf Terjadi kesalahan Internal...');
                            }
                        }
                    }
                })
            })
            $('#formUpdate').submit(function(e){
                e.preventDefault();
                $.ajax({
                    url: "{{ route('update.asrama') }}",
                    type: "post",
                    data: $(this).serialize(),
                    success: function(res){
                        $('#modalEdit').modal('hide');
                        Swal.fire({
                            title: res.message,
                            icon: 'success',
                            toast: true,
                            timer: 1300,
                            position: 'top-end',
                            showConfirmButton: false,
                            timerProgressBar: true,
                        }).then(()=>{
                            $('#tbl_asrama').DataTable().ajax.reload();
                        });
                    },
                    error: function(xhr, error){
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
                                toastr.error('Maaf Terjadi kesalahan Internal...');
                            }
                        }
                    }
                });
            })

            $('body').on('click', '#delete', function(){
                var id = $(this).attr('data-id');
                var name = $(this).attr('data-name');
                Swal.fire({
                    title: 'Akan Menghapus asrama?',
                    text: "Asrama "+name+" Akan Terhapus !",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus!'
                }).then((value)=>{
                    if(value.isConfirmed){
                        $.ajax({
                            url: "{{ route('asrama.delete') }}",
                            type: 'POST',
                            data: {
                                aid: id,
                                _token: '{{ csrf_token() }}',
                            },
                            success: function(res){
                                console.log(res);
                                Swal.fire({
                                    title: res.message,
                                    icon: 'success',
                                    toast: true,
                                    timer: 1000,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timerProgressBar: true,
                                }).then(()=>{
                                    $('#tbl_asrama').DataTable().ajax.reload();
                                });
                            },
                            error: function(xhr, error){
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
                                        toastr.error('Maaf Terjadi kesalahan Internal...');
                                    }
                                }
                            }
                        })
                    }
                    return;
                });
            })


            $('#modalEdit').on('hide.bs.modal', function(){
                var form = document.getElementById('formEdit');
                if (form) {
                    form.reset();
                }
            })
            $('#modalAdd').on('hide.bs.modal', function(){
                var form = document.getElementById('formAdd');
                if (form) {
                    form.reset();
                }
            })
        })
    </script>
@endpush
