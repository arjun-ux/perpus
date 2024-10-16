@extends('partials._app')
@section('content')
@push('cssPage')
<link rel="stylesheet" href="{{ asset('assets/vendors/dropify/dist/dropify.min.css') }}">
@endpush
<div class="page-content">
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">Settings Aplikasi</h4>
        </div>
        <div class="d-flex align-items-center flex-wrap text-nowrap">

        </div>
    </div>

    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form id="formAdd">
                    @csrf
                    <div class="mb-3">
                        <label for="addnama" class="form-label">Nama Lembaga</label>
                        <input type="text" class="form-control" id="addnama" name="lembaga"
                        autocomplete="off" required placeholder="Nama Lembaga" >
                    </div>
                    <div class="mb-3">
                        <label for="addalamat" class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="addalamat" name="address"
                        autocomplete="off" required placeholder="Contoh: Desa, Kecamatan, Kabupaten" >
                    </div>
                    <div class="mb-3">
                        <label for="addborrow_due" class="form-label">Masa Peminjaman</label>
                        <input type="number" class="form-control" id="addborrow_due" name="borrowing_due"
                        autocomplete="off" required placeholder="Contoh: 3 Hari" >
                    </div>
                    <div class="mb-3">
                        <label for="adddenda" class="form-label">Denda Jika Terlambat</label>
                        <input type="text" class="form-control" id="adddenda" name="denda"
                        autocomplete="off" required placeholder="Contoh: Rp. 2000" oninput="formatRupiah(this)">
                    </div>

                    <div class="mb-3">
                        <label for="addlogo" class="form-label">Logo Lembaga</label>
                        <input type="file" name="file" id="logo" required/>
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

    $('#formAdd').submit(function(e){
        e.preventDefault();
        var formdata = new FormData(this);
        $.ajax({
            url: "{{ route('settings.store') }}",
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
                window.location.href="{{ route('settings.index') }}";
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
