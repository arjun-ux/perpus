@extends('partials._app')
@section('content')
    <div class="page-content">
        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
            <div>
                <h4 class="mb-3 mb-md-0">Data Anggota</h4>
            </div>
            <div class="d-flex align-items-center flex-wrap text-nowrap">
                <button type="button" id="triggerModalAdd" class="btn btn-outline-primary btn-icon-text me-2 mb-2 mb-md-0">
                    <i class="btn-icon-prepend" data-feather="user"></i> Add
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
                                    <th>USERNAME</th>
                                    <th>NAMA</th>
                                    <th>KELAS</th>
                                    <th>STATUS MEMBERSHIP</th>
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
        @includeIf('member._add')
        @includeIf('member._edit')
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
                    url: "{{ route('member.store') }}",
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
                    url: "{{ route('member.data') }}",
                },
                columns: [
                    {data: 'DT_RowIndex', orderable: false, searchable: false,},
                    {data: 'username'},
                    {data: 'name'},
                    {data: 'kelas'},
                    {data: 'status'},
                    { data: 'action', name: 'action', orderable: false, searchable: false,
                        render: function (data, type, row) {
                            const uid = row.username;
                            const name = row.name;
                            return `
                                <button type="button" id="edit"
                                    data-id="${uid}" data-name="${name}"
                                    class="btn btn-outline-warning btn-icon btn-xs">
                                    <i data-feather="edit-2"></i>
                                </button>
                                <button type="button" id="delete"
                                    data-id="${uid}" data-name="${name}"
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
                var uid = $(this).attr('data-id');
                var name = $(this).attr('data-name');


                $('#uid').text(uid)
                $('#member_name').text(name)
                $('#loader-container').show();
                $.ajax({
                    type: 'POST',
                    url: "{{ route('member.show') }}",
                    data: {
                        id: uid,
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
                        $('#uid').val(res.id);
                        $('#editusername').val(res.username);
                        $('#editnama').val(res.user.name);
                        $('#editclass').val(res.kelas.id)
                        $('#editstts').val(res.status)

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
                    var formData = $(this).serialize();
                    $('#modalEdit').modal('hide');
                    $('#loader-container').show();
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('member.update') }}",
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
                    title: 'Akan Menghapus Anggota?',
                    text: "Anggota "+name+" Akan Terhapus !",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus!'
                }).then((value)=>{
                    if(value.isConfirmed){
                        $('#loader-container').show();
                        $.ajax({
                            url: "{{ route('member.delete') }}",
                            type: 'POST',
                            data: {
                                uid: id,
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
