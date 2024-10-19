@extends('partials._app')
@section('content')
    <div class="page-content">
        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
            <div>
                <h4 class="mb-3 mb-md-0">Data Peminjam</h4>
            </div>
            <div class="d-flex align-items-center flex-wrap text-nowrap">
                {{--  <button type="button" id="triggerModalAdd" class="btn btn-outline-primary btn-icon-text me-2 mb-2 mb-md-0">
                    <i class="btn-icon-prepend" data-feather="book-open"></i>
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
                                    <th>NAMA MEMBER</th>
                                    <th>JUDUL BUKU</th>
                                    <th>TGL PEMINJAMAN</th>
                                    <th>TGL PENGEMBALIAN</th>
                                    <th>KONDISI BUKU</th>
                                    <th>STATUS</th>
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

            $('#tbl_user').DataTable({
                processing: false,
                serverSide: true,
                ajax: {
                    url: "{{ route('borrow.data') }}",
                },
                columns: [
                    {data: 'DT_RowIndex', orderable: false, searchable: false,},
                    {data: 'member'},
                    {data: 'buku'},
                    {data: 'borrow_date'},
                    {data: 'returned_date'},
                    {data: 'condition'},
                    {data: 'status'},
                ],
            });
        })
    </script>
@endpush
