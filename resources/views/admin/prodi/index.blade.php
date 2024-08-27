@extends('partials._app')
@section('content')
    <div class="page-content">
        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
            <div>
                <h4 class="mb-3 mb-md-0">Program Studi</h4>
            </div>
            <div class="d-flex align-items-center flex-wrap text-nowrap">
                <button type="button" id="tambahProdi" class="btn btn-outline-primary btn-icon-text me-2 mb-2 mb-md-0">
                    <i class="btn-icon-prepend" data-feather="plus"></i> Buat
                </button>
            </div>
        </div>
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="tbl_prodi" style="width: 100%;">
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
        @includeIf('admin.prodi._add')
        @includeIf('admin.prodi._edit')
    </div>
@endsection
@push('script')
    <script>
        $(document).ready(function() {
            $('#tbl_prodi').DataTable({
                processing: false,
                serverSide: true,
                ajax: {
                    url: "{{ route('prodi.data') }}",
                },
                columns: [
                    {data: 'DT_RowIndex',name:'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'nama_prodi'},
                    {data: 'action', name: 'action', orderable: false, searchable: false,
                        render: function (data, type, row) {
                            const pid = row.id;
                            const nama = row.nama_prodi;
                            return `
                                <button type="button" id="edit"
                                    data-id="${pid}" data-name="${nama}"
                                    class="btn btn-outline-warning btn-icon btn-xs">
                                    <i data-feather="edit-2"></i>
                                </button>
                                <button type="button" id="delete"
                                    data-id="${pid}" data-name="${nama}"
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

            $('#tambahProdi').click(function(){
                $('#modalAdd').modal('show')
            })
            $('#formAdd').submit(function(e){
                e.preventDefault();
                $.ajax({
                    url: "{{ route('prodi.store') }}",
                    type: 'POST',
                    data: $(this).serialize(),
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
                            $('#tbl_prodi').DataTable().ajax.reload();
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
                                toastr.error('Terjadi kesalahan: ' + xhr.status + ' ' + xhr.statusText);
                            }
                        }
                    }
                });
            })

            $('body').on('click','#edit', function(){
                var id = $(this).attr('data-id');
                var title = $(this).attr('data-name');
                $('#nama_title').text(title);
                $.ajax({
                    url: "{{ route('prodi.get') }}",
                    type: "post",
                    data: {
                        pid:id,
                        _token: "{{ csrf_token() }}",
                    },
                    success: function(res){
                        console.log(res)
                        $('#pid').val(res.id);
                        $('#edit_nama').val(res.nama_prodi);
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
                                toastr.error('Terjadi kesalahan: ' + xhr.status + ' ' + xhr.statusText);
                            }
                        }
                    }
                })
            })
            $('#formUpdate').submit(function(e){
                e.preventDefault();
                $.ajax({
                    url: "{{ route('prodi.update') }}",
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
                            $('#tbl_prodi').DataTable().ajax.reload();
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
                                toastr.error('Terjadi kesalahan: ' + xhr.status + ' ' + xhr.statusText);
                            }
                        }
                    }
                });
            })


            $('body').on('click', '#delete', function(){
                const id = $(this).attr('data-id');
                const nama = $(this).attr('data-name');
                Swal.fire({
                    title: 'Akan Menghapus Program Studi?',
                    text: "Program Studi "+nama+" Akan Terhapus !",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus!'
                }).then((value)=>{
                    if(value.isConfirmed){
                        $.ajax({
                            url: "{{ route('prodi.delete') }}",
                            type: 'POST',
                            data: {
                                pid: id,
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
                                    $('#tbl_prodi').DataTable().ajax.reload();
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
                                        toastr.error('Terjadi kesalahan: ' + xhr.status + ' ' + xhr.statusText);
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
        });
    </script>
@endpush
