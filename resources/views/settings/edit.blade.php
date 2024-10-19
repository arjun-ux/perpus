@extends('partials._app')
@section('content')
@push('cssPage')
<link rel="stylesheet" href="{{ asset('assets/vendors/dropify/dist/dropify.min.css') }}">
@endpush
<div class="page-content">
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">E-Perpus {{ $setting->lembaga }}</h4>
        </div>
        <div class="d-flex align-items-center flex-wrap text-nowrap">

        </div>
    </div>

    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form id="formEdit">
                    @csrf
                    <div class="mb-3">
                        <label for="editnama" class="form-label">Nama Lembaga</label>
                        <input type="text" class="form-control" id="editnama" name="lembaga"
                        autocomplete="off" required value="{{ $setting->lembaga }}" >
                    </div>
                    <div class="mb-3">
                        <label for="editalamat" class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="editalamat" name="address"
                        autocomplete="off" required value="{{ $setting->address }}" >
                    </div>
                    <div class="mb-3">
                        <label for="editborrow_due" class="form-label">Masa Peminjaman</label>
                        <input type="number" class="form-control" id="editborrow_due" name="borrowing_due"
                        autocomplete="off" required value="{{ $setting->borrowing_due }}">
                    </div>
                    <div class="mb-3">
                        <label for="editdenda" class="form-label">Denda Jika Terlambat</label>
                        <input type="text" class="form-control" id="editdenda" name="denda"
                        autocomplete="off" required value="{{ $setting->denda }}" oninput="formatRupiah(this)">
                    </div>
                    <div class="mb-3">
                        <label for="edithilang" class="form-label">Denda Jika Buku Hilang</label>
                        <input type="text" class="form-control" id="edithilang" name="denda_hilang"
                        autocomplete="off" required value="{{ $setting->denda_hilang }}" oninput="formatRupiah(this)">
                    </div>

                    <div class="mb-3">
                        <label for="editlogo" class="form-label">Logo Lembaga</label>
                        <input type="file" name="file" id="logo" />
                    </div>

                    <button type="submit" class="btn btn-primary me-2">Simpan</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="btn-close">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
<script src="{{ asset('assets/vendors/dropify/dist/dropify.min.js') }}"></script>
<script src="{{ asset('assets/js/dropify.js') }}"></script>
<script>

    $('#formEdit').submit(function(e){
        e.preventDefault();
        var formdata = new FormData(this);
        $.ajax({
            url: "{{ route('settings.update') }}",
            method: 'POST',
            data: formdata,
            contentType: false,
            processData: false,
            success: function(res){
                Swal.fire({
                    title: res.message,
                    icon: 'success',
                    toast: true,
                    timer: 1000,
                    position: 'top-end',
                    showConfirmButton: false,
                    timerProgressBar: true,
                });
                {{--  window.location.href="{{ route('settings.index') }}";  --}}
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


    {{--  format rupiah  --}}
    function formatRupiah(element) {
        let value = element.value.replace(/[^0-9]/g, '');
        element.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ".").replace(/^(.*)$/, 'Rp. $1');
    }
</script>
@endpush
