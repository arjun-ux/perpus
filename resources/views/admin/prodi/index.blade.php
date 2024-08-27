@extends('partials._app')
@section('content')
    <div class="page-content">
        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
            <div>
                <h4 class="mb-3 mb-md-0">Program Studi</h4>
            </div>
            <div class="d-flex align-items-center flex-wrap text-nowrap">
                <button type="button" class="btn btn-outline-primary btn-icon-text me-2 mb-2 mb-md-0">
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
            })
        });
    </script>
@endpush
