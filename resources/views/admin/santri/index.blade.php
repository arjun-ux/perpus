@extends('partials._app')
@section('content')
    <div class="page-content">
        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
            <div>
                <h4 class="mb-3 mb-md-0">Data Santri / Mahasiswa</h4>
            </div>
            <div class="d-flex align-items-center flex-wrap text-nowrap">
                <button type="button" class="btn btn-outline-primary btn-sm btn-icon-text me-2 mb-2 mb-md-0">
                    <i class="btn-icon-prepend" data-feather="user-plus"></i> Santri
                </button>
                <button type="button" class="btn btn-outline-success btn-sm btn-icon-text me-2 mb-2 mb-md-0">
                    <i class="btn-icon-prepend" data-feather="upload-cloud"></i> Import Excel
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
                        <table class="table table-hover" id="tbl_santri" style="width: 100%;">
                            <thead>
                                <tr>
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
    </div>
@endsection
@push('script')
    <script>
        $(document).ready(function(){
            $('#tbl_santri').DataTable({
                processing: false,
                serverSide: true,
                ajax: {
                    url: "{{ route('data_santri') }}",
                },
                columns: [
                    {data: 'DT_RowIndex',orderable: false, searchable: false},
                    {data: 'nama_lengkap'},
                    {data: 'nim'},
                    {data: 'niup'},
                    {
                        data: 'stts',
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
        })
    </script>
@endpush
