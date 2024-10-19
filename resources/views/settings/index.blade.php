@extends('partials._app')
@section('content')
<div class="page-content">
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">Settings Up</h4>
        </div>
        <div class="d-flex align-items-center flex-wrap text-nowrap">
            @if ($sudahSet == true)
            <a href="{{ route('settings.edit') }}" class="btn btn-outline-warning btn-icon-text me-2 mb-2 mb-md-0">
                <i class="btn-icon-prepend" data-feather="edit"></i> Edit Aplikasi
            </a>
            @endif
        </div>
    </div>

    @if ($sudahSet == true)
    <div class="row">
        <div class="col-md-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Identitas Aplikasi Perpustakaan</h4>
                    <div class="row">
                        <div class="col-md-6 mb-5">
                            <h5>Nama Aplikasi:</h5>
                            <p>E-Perpus <span>{{ $haveSet->lembaga }}</span></p>
                            <h5>Pemilik:</h5>
                            <p>{{ $haveSet->lembaga }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5>Alamat:</h5>
                            <p>Jl. Perpustakaan No. 123, Jakarta</p>
                            <h5>Tanggal Rilis:</h5>
                            <p>{{ Carbon\Carbon::parse($haveSet->created_at)->format('d F Y'); }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <img class="img-fluid" src="{{ asset('storage/logo/' . basename($haveSet->image)) }}" alt="Logo Lembaga">
                </div>
            </div>
        </div>

    </div>
    @else
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="alert alert-warning">
                        <h4>Aplikasi Belum di Setting!!!</h4>
                    </div>
                    <a href="{{ route('settings.create') }}" class="btn btn-outline-primary btn-icon-text me-2 mb-2 mb-md-0">
                        <i class="btn-icon-prepend" data-feather="settings"></i> Setting Sekarang
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
@push('script')
<script>
    $('#trigerReset').click(function(){
        Swal.fire({
            title: 'Akan Mereset Apliksi?',
            text: "Aplikasi Akan Ke Setelan Default !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Reset!'
        }).then((value)=>{
            if(value.isConfirmed){
                $.ajax({
                    url: "{{ route('settings.reset') }}",
                    type: 'POST',
                    data: {
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
                            window.location.reload();
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
            return;
        })
    });

</script>
@endpush
