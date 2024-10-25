@extends('partials._app')
@section('content')
    <div class="page-content">
        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
            <div>
                <h4 class="mb-3 mb-md-0">Pengembalian</h4>
            </div>
            <div class="d-flex align-items-center flex-wrap text-nowrap">

            </div>
        </div>
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <form id="formAdd">
                                @csrf
                                <div class="mb-3">
                                    <label for="addIdMember" class="form-label">NOMOR INDUK SISWA (NIS)</label>
                                    <input type="text" class="form-control" id="addIdMember" name="username"
                                    autocomplete="off" required placeholder="Masukan Nis" autofocus>
                                </div>
                                <div class="mb-3">
                                    <label for="addkondisi" class="form-label">KONDISI</label>
                                    <select name="condition" id="addkondisi" class="form-select" required>
                                        <option value="">Pilih Kondisi</option>
                                        <option value="Baik">Baik</option>
                                        <option value="Rusak">Rusak</option>
                                        <option value="Hilang">Hilang</option>
                                    </select>
                                </div>
                                <input type="hidden" name="borrow_id" id="borrow_id">
                                <input type="hidden" name="keterlambatan" id="keterlambatan">
                                <input type="hidden" name="total_denda" id="total_denda">

                                <div class="mb-3" id="btnsave" style="display: none">
                                    <button type="submit" class="form-control btn btn-outline-success btn-icon-text me-2 mb-2 mb-md-0">
                                        <i class="btn-icon-prepend" data-feather="book"></i> Kembalikan
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-8" id="wrapper-results" style="display: none">
                            <div class="alert alert-danger" style="display: none">
                                <h6>Denda Kerusakan Atau Kehilangan Buku Sebesar <span id="denda_hilang"></span></h6>
                                <h6>Denda Kerusakan Atau Kehilangan Buku Sebesar <span id="denda_awal"></span></h6>
                            </div>
                            <div class="row justify-content-center text-center">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">NOMOR INDUK SISWA (NIS)</label>
                                        <h5 id="member_id"></h5>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">NAMA MEMBER</label>
                                        <h5 id="member_name"></h5>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">KETERLAMBATAN</label>
                                        <h5 id="terlambat"></h5>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">KELAS</label>
                                        <h5 id="member_kls"></h5>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">STATUS PINJAMAN</label>
                                        <h5 id="status_pinjaman"></h5>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">DENDA</label>
                                        <h5 id="denda"></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 grid-margin stretch-card" id="cardbook" style="display: none">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">JUDUL BUKU</label>
                                <h5 id="title"></h5>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">PENULIS</label>
                                <h5 id="author"></h5>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">KONDISI AWAL BUKU</label>
                                <h5 id="condition"></h5>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3 text-center">
                                <img src="{{ asset('assets/images/logo.png') }}" alt="Buku" class="img-fluid" width="150px">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        $(document).ready(function(){

            $('#addIdMember').on('input', function() {
                var nilai = $(this).val();

                if(nilai.length == 10){
                    $('#loader-container').show()
                    $.ajax({
                        url: "{{ route('returns.borrow') }}",
                        method: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            username: nilai,
                        },
                        success: function(res){
                            $('#loader-container').hide()
                            $('#member_id').text(res.member.username)
                            $('#member_name').text(res.member.user.name)
                            $('#member_kls').text(res.member.kelas.name)

                            $('#denda_awal').text(res.overdue.fine)
                            $('#denda_hilang').text(res.setting.denda_hilang)
                            console.log($('#denda_awal').text(res.overdue.fine))
                            console.log($('#denda_hilang').text(res.setting.denda_hilang))
                            var late = res.total_fine;
                            $('#borrow_id').val(res.borrow.id)
                            $('#keterlambatan').val(res.overdue.overdue_days)
                            $('#total_denda').val(late)


                            if(late == 0 ){
                                $('#denda').html('<span class="badge bg-success">Tidak Ada Denda</span>');
                                $('#status_pinjaman').html('<span class="badge bg-success">Tidak Terlambat</span>');
                                $('#terlambat').html('<span class="badge bg-success">Tidak Terlambat</span>');
                            }else{
                                $('#denda').text(formatRupiah(res.overdue.fine))
                                $('#status_pinjaman').html('<span class="badge bg-danger">Terlambat</span>');
                                $('#terlambat').text((res.overdue.overdue_days+" Hari"))
                            }

                            {{--  identitas buku  --}}
                            $('#title').text(res.book.title)
                            $('#author').text(res.book.author)

                            var kondisi = res.borrow.condition;
                            if(kondisi == "Baik"){
                                $('#condition').html('<span class="badge bg-success">Baik</span>');
                            }else{
                                $('#condition').html('<span class="badge bg-danger">Rusak</span>');
                            }



                            $('#btnsave').show();
                            $('#cardbook').show();
                            $('#wrapper-results').show();

                        },
                        error: function(xhr, error){
                            $('#loader-container').hide()
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
                }else{
                    $(this).val(nilai.substring(0, 10));
                }
            });

            $('#addkondisi').on('change', function() {
                hitungDenda();
            });

            function hitungDenda() {
                var kondisi_awal = $('#condition').text().trim();
                var kondisi_kembali = $('#addkondisi').val();
                var dendaAwal = parseInt($('#denda_awal').text().replace(/[^\d]/g, '')) || 0;
                var dendaHilang = parseInt($('#denda_hilang').text().replace(/[^\d]/g, '')) || 0;

                console.log(dendaAwal)
                console.log(dendaHilang)
                var totalDenda = dendaAwal; // Inisialisasi dengan denda awal (keterlambatan)

                // Jika kondisi awal dan kondisi kembali berbeda
                if (kondisi_awal !== kondisi_kembali) {
                    if (kondisi_kembali === 'Rusak' && kondisi_awal === 'Baik') {
                        // Dari Baik ke Rusak
                        totalDenda += dendaHilang;
                    } else if (kondisi_kembali === 'Hilang') {
                        // Jika berubah menjadi Hilang, selalu tambahkan denda hilang
                        totalDenda += dendaHilang;
                    }
                }
                // Jika kondisi awal dan kondisi kembali sama, hanya denda awal (keterlambatan) yang dibebankan

                // Update tampilan
                $('#denda').text(formatRupiah(totalDenda));
                $('#total_denda').val(totalDenda);
            }






            $('#formAdd').submit(function(e){
                e.preventDefault();
                $('#loader-container').show()
                $.ajax({
                    url: "{{ route('pengembalian.store') }}",
                    method: 'POST',
                    data: $('#formAdd').serialize(),
                    success: function(res){
                        $('#loader-container').hide()
                        Swal.fire({
                            title: res.message,
                            icon: 'success',
                            toast: true,
                            timer: 1000,
                            position: 'top-end',
                            showConfirmButton: false,
                            timerProgressBar: true,
                        });
                        window.location.reload();
                    },
                    error: function(xhr, error){
                        $('#loader-container').hide()
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

            function formatRupiah(angka) {
                const format = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0, // Hilangkan desimal
                    maximumFractionDigits: 0 ,
                });
                return format.format(angka);
            }
        })
    </script>
@endpush
