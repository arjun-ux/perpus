@extends('partial1._app')
@section('content')
@php
    use Carbon\Carbon;
@endphp
<div class="page-content">

    <div class="row">
      <div class="col-12 grid-margin">
        <div class="card">
          <div class="position-relative">
            <figure class="overflow-hidden mb-0 d-flex justify-content-center">
              <img src="{{ asset('assets/images/kop.png') }}"class="rounded-top img-thumbnail" alt="profile cover" width="100%">
            </figure>
            <div class="d-flex justify-content-between align-items-center position-absolute top-90 w-100 px-2 px-md-4 mt-n4">
              <div>
                <img class="wd-70 rounded-circle" src="{{ asset('assets/images/logo.png') }}" alt="profile" >
                <span class="h4 ms-3 text-dark">{{ Auth::user()->name }}</span>
              </div>
              <div class="d-none d-md-block">
              </div>
            </div>
          </div>
            <div class="d-flex justify-content-center p-3 rounded-bottom">
            </div>
        </div>
      </div>
    </div>
    <div class="row ">
      <!-- wrapper about -->
        <div class="col-md-9 mb-2" id="about">
            <div class="card rounded">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h6 class="card-title mb-0">Tentang</h6>
                        <div class="dropdown">
                            <a type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item d-flex align-items-center" id="edit" href="javascript:;"><i data-feather="edit-2" class="icon-sm me-2"></i> <span class="">Edit</span></a>
                            </div>
                        </div>
                    </div>
                    <p>Halo, Saya {{ Auth::user()->name }} Santri Pondok Pesantren Nurul Jadid Paiton.</p>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mt-3">
                                <label class="tx-11 fw-bolder mb-0 text-uppercase">Nama Lengkap :</label>
                                <p class="text-muted">{{ Auth::user()->name }}</p>
                            </div>
                            <div class="mt-3">
                                <label class="tx-11 fw-bolder mb-0 text-uppercase">Email :</label>
                                <p class="text-muted">{{ Auth::user()->email ? Auth::user()->email : 'Email Tidak Ada' }}</p>
                            </div>
                            <div class="mt-3">
                                <label class="tx-11 fw-bolder mb-0 text-uppercase">NIUP :</label>
                                <p class="text-muted">{{ $data->niup ? $data->niup : 'Niup Tidak Ada' }}</p>
                            </div>
                            <div class="mt-3">
                                <label class="tx-11 fw-bolder mb-0 text-uppercase">NIM :</label>
                                <p class="text-muted">{{ $data->nim ? $data->nim : 'Nim Tidak Ada' }}</p>
                            </div>
                            <div class="mt-3">
                                <label class="tx-11 fw-bolder mb-0 text-uppercase">TEMPAT, TANGGAL LAHIR :</label>
                                <p class="text-muted">{{ $data->tmp_lahir ? $data->tmp_lahir : 'Tempat Lahir Tidak Ada' }},
                                    {{ Carbon::parse($data->tgl_lahir)->translatedFormat('d F Y') ? Carbon::parse($data->tgl_lahir)->translatedFormat('d F Y') : 'Tanggal Lahir Tidak Ada' }}
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mt-3">
                                <label class="tx-11 fw-bolder mb-0 text-uppercase">JENIS KELAMIN :</label>
                                @if ($data->jenis_kelamin == 'P')
                                    <p class="text-muted">Perempuan</p>
                                @else
                                    <p class="text-muted">Laki-Laki</p>
                                @endif
                            </div>
                            <div class="mt-3">
                                <label class="tx-11 fw-bolder mb-0 text-uppercase">SKILL :</label>
                                <p class="text-muted">{{ $data->skill ? $data->skill : 'Skill Tidak Ada' }}</p>
                            </div>
                            <div class="mt-3">
                                <label class="tx-11 fw-bolder mb-0 text-uppercase">NO ORANG TUA :</label>
                                <p class="text-muted">{{ $data->no_ortu ? $data->no_ortu : 'No Orang Tua Tidak Ada' }}</p>
                            </div>
                            <div class="mt-3">
                                <label class="tx-11 fw-bolder mb-0 text-uppercase">ID Telegram :</label>
                                <p class="text-muted">{{ $data->id_telegram ? $data->id_telegram : 'ID Telegram Tidak Ada' }}</p>
                            </div>
                            <div class="mt-3">
                                <label class="tx-11 fw-bolder mb-0 text-uppercase">STATUS :</label>
                                @if ($data->stts == 'Aktif')
                                    <div class="badge bg-success">
                                        <p class="text-uppercase">{{ $data->stts ? $data->stts : 'Status Tidak Ada' }}</p>
                                    </div>
                                @else
                                    <div class="badge bg-danger">
                                        <p class="text-uppercase">{{ $data->stts ? $data->stts : 'Status Tidak Ada' }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- wrap form edit -->
        <div class="col-md-9 mb-2" id="formEdit" style="display: none">
            <div class="card rounded">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h6 class="card-title mb-0">Edit</h6>
                    </div>
                    <p>Hi! Im Amiah the Senior UI Designer at NobleUI. We hope you enjoy the design and quality of Social.</p>
                    <div class="mt-3">
                        <label class="tx-11 fw-bolder mb-0 text-uppercase">Joined:</label>
                        <p class="text-muted">November 15, 2015</p>
                    </div>
                    <div class="mt-3">
                        <label class="tx-11 fw-bolder mb-0 text-uppercase">Lives:</label>
                        <p class="text-muted">New York, USA</p>
                    </div>
                    <div class="mt-3">
                        <label class="tx-11 fw-bolder mb-0 text-uppercase">Email:</label>
                        <p class="text-muted">me@nobleui.com</p>
                    </div>
                    <div class="mt-3">
                        <label class="tx-11 fw-bolder mb-0 text-uppercase">Website:</label>
                        <p class="text-muted">www.nobleui.com</p>
                    </div>
                </div>
            </div>
        </div>
      <!-- middle wrapper end -->
      <!-- right wrapper start -->
        <div class="col-md-3">
            <div class="row">
                <div class="col-md-12 grid-margin">
                    <div class="card rounded">
                        <div class="card-body">
                            <h6 class="card-title">History</h6>
                            <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                                <div class="d-flex align-items-center hover-pointer">
                                    <div class="ms-2">
                                        <p>Mike Popescu</p>
                                        <p class="tx-11 text-muted">12 Mutual Friends</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      <!-- right wrapper end -->
    </div>

        </div>
@endsection
@push('script')
    <script>
        $(document).ready(function() {

            $('#edit').click(function(){
                $('#formEdit').show()
                $('#about').hide()
            })


        })
    </script>
@endpush
