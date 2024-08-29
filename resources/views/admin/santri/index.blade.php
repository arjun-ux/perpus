@extends('partials._app')
@push('cssPage')
    <link rel="stylesheet" href="{{ asset('assets/vendors/dropify/dist/dropify.min.css') }}">
@endpush
@section('content')
    <div class="page-content">
        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
            <div>
                <h4 class="mb-3 mb-md-0">Data Santri / Mahasiswa</h4>
            </div>
            <div class="d-flex align-items-center flex-wrap text-nowrap">
                <button type="button" id="generateUser" class="btn btn-info btn-sm btn-icon-text me-2 mb-2 mb-md-0" style="display: none">
                    <i class="btn-icon-prepend" data-feather="user-plus"></i> Create User
                </button>
                <a href="{{ route('santri.create') }}" class="btn btn-outline-primary btn-sm btn-icon-text me-2 mb-2 mb-md-0">
                    <i class="btn-icon-prepend" data-feather="user-plus"></i> Santri
                </a>
                <button type="button" id="importExcel" class="btn btn-outline-success btn-sm btn-icon-text me-2 mb-2 mb-md-0">
                    <i class="btn-icon-prepend" data-feather="upload-cloud"></i> Import Excel
                </button>
                {{--  <button type="button" id="exportExcel" class="btn btn-outline-warning btn-sm btn-icon-text me-2 mb-2 mb-md-0">
                    <i class="btn-icon-prepend" data-feather="download-cloud"></i> Export Excel
                </button>  --}}
            </div>
        </div>
        <div class="col-md-12 grid-margin stretch-card" id="importMahasiswa" style="display: none">
            <div class="card">
                <div class="card-body">
                    <form id="formImport" enctype="multipart/form-data">
                        @csrf
                            <div>
                                <h6 class="card-title">Area Import Data Mahasiswa</h6>
                                <input type="file" id="importSantri" name="file_santri" accept=".xlsx,.xls"/>
                            </div>

                        <button type="submit" class="btn btn-primary me-2 mt-3">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card" id="card_santri">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="tbl_santri" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="selectTh"></th>
                                        <th>NO</th>
                                        <th>NAMA</th>
                                        <th>NIM</th>
                                        <th>NIUP</th>
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
            <div class="col-md-4 grid-margin stretch-card" id="lihat-penugasan" style="display: none">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Penugasan <strong id="nama_santri"></strong></h6>
                        <div id="loopingPenugasan"></div>

                    </div>
                </div>
            </div>
        </div>
        @includeIf('admin.santri._import')
    </div>
@endsection
@push('script')
<script src="{{ asset('assets/vendors/dropify/dist/dropify.min.js') }}"></script>
<script src="{{ asset('assets/js/dropify.js') }}"></script>
    <script>
        @if (session('success'))
            toastr.success('{{ session('success') }}');
        @endif
        {{--  $.ajax({
            type: 'GET',
            url: "{{ route('data_santri') }}",
            success: function(data){
                console.log(data)
            }
        })  --}}
        $(document).ready(function(){
            $('#tbl_santri').DataTable({
                processing: false,
                serverSide: true,
                ajax: {
                    url: "{{ route('data_santri') }}",
                },
                columns: [
                    {
                        data: null,
                        name: 'checkbox',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return '<input type="checkbox" name="selected_ids[]" value="' + row.id + '">';
                        }
                    },
                    {data: 'DT_RowIndex',orderable: false, searchable: false},
                    {data: 'nama_lengkap'},
                    {data: 'nim'},
                    {data: 'niup'},
                    {
                        data: 'stts',

                    },
                    { data: 'action', name: 'action', orderable: false, searchable: false,
                        render: function (data, type, row) {
                            const id = row.id;
                            const nama = row.nama_lengkap;
                            const idUser = row.user_id;
                            if(idUser == null){
                                return `
                                    <button type="button" id="delete"
                                        data-id="${id}" data-name="${nama}"
                                        class="btn btn-outline-danger btn-icon btn-xs">
                                        <i data-feather="trash-2" class="icon-sm"></i>
                                    </button>
                                    <button type="button" id="user"
                                        data-id="${id}" data-name="${nama}"
                                        class="btn btn-outline-info btn-icon btn-xs">
                                        <i data-feather="user" class="icon-sm"></i>
                                    </button>
                            `;
                            }
                            return `
                                <button type="button" id="penugasan"
                                    data-id="${id}" data-name="${nama}"
                                    class="btn btn-outline-success btn-icon btn-xs">
                                    <i data-feather="eye" class="icon-sm"></i>
                                </button>
                                <button type="button" id="delete"
                                    data-id="${id}" data-name="${nama}"
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

            $('body').on('click', '#penugasan', function(){
                const nama = $(this).attr('data-name');
                const id = $(this).attr('data-id');
                $('#nama_santri').text(nama)
                $.ajax({
                    url: "{{ route('santri.penugasan') }}",
                    type: "post",
                    data: {
                        sid: id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(res){
                        $('#card_santri').removeClass('col-md-12').addClass('col-md-8');
                        $('#lihat-penugasan').show();
                        if(res.length == 0){
                            $('#loopingPenugasan').empty();
                            var kosong = `
                                <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                                    <div class="d-flex align-items-center hover-pointer">
                                        <div class="ms-2">
                                            <p>Santri Belum Memiliki Tempat Magang</p>
                                        </div>
                                    </div>
                                </div>
                            `
                            $('#loopingPenugasan').append(kosong);

                        }else{
                            if(Array.isArray(res)){
                                $('#loopingPenugasan').empty();
                                res.forEach(function(item){
                                    const lokasi = item.mitra.nama_mitra;
                                    const status = item.status_penugasan;

                                    var looping = `
                                    <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                                        <div class="d-flex align-items-center hover-pointer">
                                            <div class="ms-2">
                                                <p>${lokasi}</p>
                                                <p class="tx-11 text-muted">${status}</p>
                                            </div>
                                        </div>
                                    </div>
                                    `
                                    $('#loopingPenugasan').append(looping);
                                })
                            }else{
                                console.log('Data Bukan array');
                            }
                        }

                    },
                    error: function(xhr){
                        console.log(xhr);
                    }
                });
            })

            $('#selectTh').change(function(){
                var isChecked = $(this).prop('checked');
                $('#tbl_santri tbody input[type="checkbox"]').prop('checked', isChecked);
                if( isChecked ){
                    $('#generateUser').show();
                }else{
                    $('#generateUser').hide();
                }
            });

            $('body').on('click', '#user', function(){
                Swal.fire({
                    title: 'Akan Menggenerate User?',
                    text: "Tindakan Ini Akan Membuat User Dari Santri Terpilih!!!",
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya!'
                }).then((value)=>{
                    if(value.isConfirmed){
                        $.ajax({
                            url: "{{ route('santri.generate.user.one') }}",
                            type: "POST",
                            data: {
                                id: $(this).attr('data-id'),
                                _token: "{{ csrf_token() }}",
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
                                    $('#tbl_santri').DataTable().ajax.reload();
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
                    }
                })
            })

            $('#generateUser').click(function(){
                var selectedIds = [];
                $('#tbl_santri tbody input[type="checkbox"]:checked').each(function(){
                    selectedIds.push($(this).val());
                });
                Swal.fire({
                    title: 'Akan Menggenerate User?',
                    text: "Tindakan Ini Akan Membuat User Dari Santri Terpilih!!!",
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya!'
                }).then((value)=>{
                    if(value.isConfirmed){
                        // ajax post
                        $.ajax({
                            type: 'POST',
                            url: '{{ route('santri.generate.user') }}',
                            data: {
                                ids: selectedIds,
                                _token: "{{ csrf_token() }}"
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
                                    $('#tbl_santri').DataTable().ajax.reload();
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
                })
            });


            $('#importExcel').click(function(){
                $('#importMahasiswa').show();
            })
            $('#formImport').submit(function(e){
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url : "{{ route('santri.import') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function(res){
                        Swal.fire({
                            title: res.message,
                            icon: 'success',
                            toast: true,
                            timer: 1300,
                            position: 'top-end',
                            showConfirmButton: false,
                            timerProgressBar: true,
                        }).then(()=>{
                            $('#importMahasiswa').hide();
                            $('#tbl_santri').DataTable().ajax.reload();
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
            });


            $('body').on('click', '#delete', function(){
                const id = $(this).attr('data-id');
                const nama = $(this).attr('data-name');
                Swal.fire({
                    title: 'Akan Menghapus Santri?',
                    text: "Santri "+nama+" Akan Terhapus !",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus!'
                }).then((value)=>{
                    if(value.isConfirmed){
                        $.ajax({
                            url: "{{ route('santri.delete') }}",
                            type: 'POST',
                            data: {
                                sid: id,
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
                                    $('#tbl_santri').DataTable().ajax.reload();
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
        })
    </script>
@endpush
