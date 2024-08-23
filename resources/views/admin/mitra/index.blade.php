@extends('partials._app')
@section('content')
    <div class="page-content">
        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
            <div>
                <h4 class="mb-3 mb-md-0">Data Mitra</h4>
            </div>
            <div class="d-flex align-items-center flex-wrap text-nowrap">
                <button type="button" id="tambahMitra" class="btn btn-outline-primary btn-sm btn-icon-text me-2 mb-2 mb-md-0">
                    <i class="btn-icon-prepend" data-feather="user-plus"></i> Mitra
                </button>
                <button type="button" class="btn btn-outline-warning btn-sm btn-icon-text me-2 mb-2 mb-md-0">
                    <i class="btn-icon-prepend" data-feather="download-cloud"></i> Export Excel
                </button>
            </div>
        </div>
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="tbl_mitra" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>NAMA</th>
                                    <th>ALAMAT</th>
                                    <th>KONTAK</th>
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
        @includeIf('admin.mitra._add')
        @includeIf('admin.mitra._edit')
    </div>
@endsection
@push('script')
    <script>
        $(document).ready(function(){
            $('#tbl_mitra').DataTable({
                processing: false,
                serverSide: true,
                ajax: {
                    url: "{{ route('data_mitra_admin') }}",
                    type: "GET",
                },
                columns: [
                    {data: 'DT_RowIndex',orderable: false, searchable: false},
                    {data: 'nama_mitra'},
                    {data: 'alamat_mitra'},
                    {data: 'kontak_mitra'},
                    { data: 'action', name: 'action', orderable: false, searchable: false,
                        render: function (data, type, row) {
                            const mid = row.id;
                            const nama = row.nama_mitra;
                            return `
                                <button type="button" id="edit"
                                    data-id="${mid}" data-name="${nama}"
                                    class="btn btn-outline-warning btn-icon btn-xs">
                                    <i data-feather="edit-2"></i>
                                </button>
                                <button type="button" id="delete"
                                    data-id="${mid}"
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

            $('#tambahMitra').click(function(){
                $('#modalAdd').modal('show');
            })
            $('#formAdd').submit(function(e){
                e.preventDefault();
                $.ajax({
                    url: "{{ route('store_mitra_admin') }}",
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
                            $('#tbl_mitra').DataTable().ajax.reload();
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
            })

            $('body').on('click','#edit', function(){
                var id = $(this).attr('data-id');
                var title = $(this).attr('data-name');
                $('#nama_title').text(title);
                $.ajax({
                    url: "{{ route('getMitra') }}",
                    type: "post",
                    data: {
                        mid:id,
                        _token: "{{ csrf_token() }}",
                    },
                    success: function(res){
                        console.log(res)
                        $('#mid').val(res.id);
                        $('#edit_nama').val(res.nama_mitra);
                        $('#edit_alamat').val(res.alamat_mitra);
                        $('#edit_kontak').val(res.kontak_mitra);
                        $('#edit_kontak').val(res.kontak_mitra);
                        $('#edit_email').val(res.user.email);
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
                    url: "{{ route('update_mitra') }}",
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
                            $('#tbl_mitra').DataTable().ajax.reload();
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
