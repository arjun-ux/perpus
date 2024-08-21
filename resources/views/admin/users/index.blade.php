@extends('partials._app')
@section('content')
    <div class="page-content">
        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
            <div>
                <h4 class="mb-3 mb-md-0">Users</h4>
            </div>
            <div class="d-flex align-items-center flex-wrap text-nowrap">
                {{--  <button type="button" class="btn btn-outline-primary btn-icon-text me-2 mb-2 mb-md-0">
                    <i data-feather="user-plus" class="icon-sm"></i>
                </button>  --}}
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
                                    <th>USERNAME</th>
                                    <th>EMAIL</th>
                                    <th>ROLE</th>
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
        @includeIf('admin.users._edit')
    </div>
@endsection
@push('script')
    <script>
        $(document).ready(function(){
            $('#tbl_user').DataTable({
                processing: false,
                serverSide: true,
                ajax: {
                    url: "{{ route('data.user') }}",
                },
                columns: [
                    {data: 'DT_RowIndex', orderable: false, searchable: false,},
                    {data: 'name'},
                    {data: 'username'},
                    {data: 'email'},
                    {data: 'role'},

                    { data: 'action', name: 'action', orderable: false, searchable: false,
                        render: function (data, type, row) {
                            const uid = row.id;
                            const name = row.name;
                            return `
                                <button type="button" id="edit"
                                    data-id="${uid}" data-name="${name}"
                                    class="btn btn-outline-warning btn-icon btn-xs">
                                    <i data-feather="edit-2" class="icon-sm"></i>
                                </button>
                                {{--  <button type="button" id="delete"
                                    data-id="${uid}"
                                    class="btn btn-outline-danger btn-icon btn-xs">
                                    <i data-feather="trash-2" class="icon-sm"></i>
                                </button>  --}}
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
                $('#modalEdit').modal('show');
                $('#uid').text(uid)
                $('#nama_user').text(name)

                $.ajax({
                    type: 'POST',
                    url: "{{ route('user_id') }}",
                    data: {
                        id: uid,
                        _token: "{{ csrf_token() }}",
                    },
                    success: function(res){
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
                        $('#editnama').val(res.name);
                        $('#editusername').val(res.username);
                        $('#editemail').val(res.email);
                        $('#editrole').val(res.role);
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
                                toastr.error('Terjadi kesalahan: ' + xhr.status + ' ' + xhr.statusText);
                            }
                        }
                    }
                })
                $('#formEdit').submit(function(e){
                    e.preventDefault();
                    var formData = $(this).serialize();
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('user_update') }}",
                        data: formData + '&_token={{ csrf_token() }}',
                        success: function(res){
                            $('#modalEdit').modal('hide');
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
            {{--  $('body').on('click', '#delete', function(){
                var id = $(this).attr('data-id');
                Swal.fire({
                    title: 'Akhiri Sesi Login?',
                    text: "User Bersangkutan Akan Logout",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, NonAktifkan!'
                }).then((value)=>{
                    if(value.isConfirmed){
                        $.ajax({
                            url: "{{ route('delete_sesi') }}",
                            type: 'POST',
                            data: {
                                sessionId: id,
                                _token: '{{ csrf_token() }}',
                            },
                            success: function(res){
                                Swal.fire({
                                    title: res.message,
                                    icon: 'success',
                                    toast: true,
                                    timer: 1000,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timerProgressBar: true,
                                }).then(()=>{
                                    $('#tbl_sesi').DataTable().ajax.reload();
                                });
                            }
                        })
                    }
                });
            });  --}}
        })
    </script>
@endpush