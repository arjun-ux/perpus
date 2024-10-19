@extends('partials._app')
@section('content')
    <div class="page-content">
        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
            <div>
                <h4 class="mb-3 mb-md-0">Laporan Perpustakaan</h4>
            </div>
            <div class="d-flex align-items-center flex-wrap text-nowrap">
                <button type="button" id="triggertgl_peminjaman" class="btn btn-outline-success btn-icon-text mb-2 mb-md-1">
                    <i class="btn-icon-prepend" data-feather="calendar"></i> Tanggal Peminjaman
                </button>
                <button type="button" id="triggertgl_pengembalian" class="btn btn-outline-primary btn-icon-text mb-2 mb-md-1">
                    <i class="btn-icon-prepend" data-feather="calendar"></i> Tanggal Pengembalian
                </button>
                <button type="button" id="triggerbymember" class="btn btn-outline-warning btn-icon-text mb-2 mb-md-1">
                    <i class="btn-icon-prepend" data-feather="user"></i> Nama Member / Anggota (Siswa)
                </button>
            </div>
        </div>
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card" id="cardtgl_peminjaman" style="display: none">
                <div class="card-body">
                    <form action="{{ route('by_tgl_peminjaman') }}" method="POST">
                        @csrf
                        <h6 class="card-title">Tanggal Peminjaman</h6>
                        <div class="input-group flatpickr" id="flatpickr-date">
                            <input type="text" class="form-control" placeholder="Select date" data-input name="tgl">
                            <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                            <button class="btn btn-primary" type="submit">Cari</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card" id="cardtgl_pengembalian" style="display: none">
                <div class="card-body">
                    <form action="{{ route('by_tgl_pengembalian') }}" method="POST">
                        @csrf
                        <h6 class="card-title">Tanggal Pengembalian</h6>
                        <div class="input-group flatpickr" id="flatpickr-date">
                            <input type="text" class="form-control" placeholder="Select date" data-input name="tgl">
                            <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                            <button class="btn btn-primary" type="submit">Cari</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card" id="cardbymember" style="display: none">
                <div class="card-body">
                    <form action="{{ route('by_member') }}" method="POST">
                        @csrf
                        <h6 class="card-title">Nama Member / Siswa</h6>
                        <div class="input-group mb-2">
                            <select class="js-example-basic-single form-select select2"
                                id="member" name="member" required data-width="100%">
                                <option value="" disabled selected>Pilih Member</option>
                            </select>
                        </div>
                        <button class="btn btn-outline-primary" type="submit">Cari</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        $(document).ready(function(){


            $('#member').select2({
                ajax: {
                    url: "{{ route('cari_member') }}",
                    dataType: 'json',
                    delay: 250, // Mengurangi jumlah request
                    data: function (params) {
                        return {
                            q: params.term, // Mengambil kata kunci dari input
                            page: params.page || 1 // Mengambil halaman saat ini
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.data.map(function(member) {
                                return {
                                    id: member.id,
                                    text: member.name,
                                };
                            }),
                            pagination: {
                                more: data.current_page < data.last_page
                            }
                        };
                    },
                    // Menangani kesalahan
                    error: function() {
                        // Tangani kesalahan di sini jika perlu
                    }
                },
                minimumInputLength: 3
            });



            $('#triggertgl_peminjaman').click(function(){
                $('#cardtgl_peminjaman').show();
                $('#cardtgl_pengembalian').hide();
                $('#cardbymember').hide();
            });
            $('#triggertgl_pengembalian').click(function(){
                $('#cardtgl_pengembalian').show();
                $('#cardtgl_peminjaman').hide();
                $('#cardbymember').hide();
            });
            $('#triggerbymember').click(function(){
                $('#cardbymember').show();
                $('#cardtgl_peminjaman').hide();
                $('#cardtgl_pengembalian').hide();
            });

        });

        @if (session('error'))
            toastr.error('{{ session('error') }}');
        @endif
    </script>

@endpush
