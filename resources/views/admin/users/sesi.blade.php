@extends('partials._app')
@section('content')
    <div class="page-content">
        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
            <div>
                <h4 class="mb-3 mb-md-0">Session Login</h4>
            </div>
            <div class="d-flex align-items-center flex-wrap text-nowrap">
                <button type="button" id="reloadTable" class="btn btn-outline-primary btn-icon-text me-2 mb-2 mb-md-0">
                    <i class="btn-icon-prepend" data-feather="rss"></i> Reload Table
                </button>
            </div>
        </div>
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="tbl_sesi" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>NAMA</th>
                                    <th>IP ADDRESS</th>
                                    <th>TERAKHIR AKTIVITAS</th>
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
    </div>
@endsection
@push('script')
    <script>
        $(document).ready(function(){
            $('#reloadTable').click(function(){
                $('#tbl_sesi').DataTable().ajax.reload();
            })
            $('#tbl_sesi').DataTable({
                processing: false,
                serverSide: true,
                ajax: {
                    url: "{{ route('data_sesi') }}",
                },
                columns: [
                    {data: 'DT_RowIndex'},
                    {data: 'user_name'},
                    {data: 'ip_address'},
                    {
                        data: 'last_activity',
                        name: 'last_activity',
                        render: function (data, type, row) {
                            return data;
                        }
                    },
                    { data: 'action', name: 'action', orderable: false, searchable: false,
                        render: function (data, type, row) {
                            const id = row.session_id;
                            return `
                                <button type="button" id="delete"
                                    data-id="${id}"
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
            $('body').on('click', '#delete', function(){
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
            });
        })

    </script>
@endpush
