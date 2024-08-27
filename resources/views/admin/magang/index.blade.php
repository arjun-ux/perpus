@extends('partials._app')
@section('content')
    <div class="page-content">
        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
            <div>
                <h4 class="mb-3 mb-md-0">Data Magang</h4>
            </div>
            <div class="d-flex align-items-center flex-wrap text-nowrap">
                <button type="button" id="tambahMagang" class="btn btn-outline-primary btn-sm btn-icon-text me-2 mb-2 mb-md-0">
                    <i class="btn-icon-prepend" data-feather="plus"></i> Magang
                </button>
            </div>
        </div>
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="tbl_magang" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>TEMA</th>
                                    <th>TGL MULAI</th>
                                    <th>TGL SELESAI</th>
                                    <th>STATUS</th>
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
        @includeIf('admin.magang._add')
        @includeIf('admin.magang._edit')
    </div>
@endsection
@push('script')
    <script>
        $(document).ready(function(){
            $('#tbl_magang').DataTable({
                processing: false,
                serverSide: true,
                ajax: {
                    url: "{{ route('magang.data') }}",
                    type: "GET",
                },
                columns: [
                    {data: 'DT_RowIndex',orderable: false, searchable: false},
                    {data: 'tema_magang'},
                    {data: 'tgl_mulai'},
                    {data: 'tgl_selesai'},
                    {
                        data: 'stts_magang',
                        render: function(data, type, row){
                            var statusText = data;
                            var statusClass = '';
                            switch(statusText.toLowerCase()){
                                case 'ongoing':
                                    statusClass = 'badge bg-warning';
                                    break;
                                case 'mulai':
                                    statusClass = 'badge bg-success';
                                    break;
                                case 'selesai':
                                    statusClass = 'badge bg-info';
                                    break;
                            }
                            return '<span class="' + statusClass + '">' + statusText + '</span>';
                        }
                    },
                    { data: 'action', name: 'action', orderable: false, searchable: false,
                        render: function (data, type, row) {
                            const mid = row.id;
                            const tema = row.tema_magang;
                            return `
                                <button type="button" id="edit"
                                    data-id="${mid}" data-name="${tema}"
                                    class="btn btn-outline-warning btn-icon btn-xs">
                                    <i data-feather="edit-2"></i>
                                </button>
                                 <button type="button" id="lihat"
                                    data-id="${mid}" data-name="${tema}"
                                    class="btn btn-outline-success btn-icon btn-xs">
                                    <i data-feather="eye" class="icon-sm"></i>
                                </button>
                                <button type="button" id="delete"
                                    data-id="${mid}" data-name="${tema}"
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

            $('#tambahMagang').click(function(){
                $('#modalAdd').modal('show');
            })
            $('#formAdd').submit(function(e){
                e.preventDefault();
                $.ajax({
                    url: "{{ route('magang.store') }}",
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
                            {{--  $('#tbl_magang').DataTable().ajax.reload();;  --}}
                            window.location.reload()
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
                    url: "{{ route('magang.id') }}",
                    type: "post",
                    data: {
                        mid:id,
                        _token: "{{ csrf_token() }}",
                    },
                    success: function(res){
                        $('#mid').val(res.id);
                        $('#edit_tema').val(res.tema_magang);
                        $('#edit_mulai').val(res.tgl_mulai);
                        $('#edit_selesai').val(res.tgl_selesai);
                        $('#stts').val(res.stts_magang);
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
                    url: "{{ route('magang.update') }}",
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
                            $('#tbl_magang').DataTable().ajax.reload();
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

            $('body').on('click', '#lihat', function(){
                alert('nanti disini untuk melihat santri yang magang');
            })
            $('body').on('click', '#delete', function(){
                var id = $(this).attr('data-id');
                var tema = $(this).attr('data-name');
                Swal.fire({
                    title: 'Akan Menghapus Magang?',
                    text: "Magang "+tema+" Akan Terhapus !",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus!'
                }).then((value)=>{
                    if(value.isConfirmed){
                        $.ajax({
                            url: "{{ route('magang.delete') }}",
                            type: 'POST',
                            data: {
                                mid: id,
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
                                    $('#tbl_magang').DataTable().ajax.reload();
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
