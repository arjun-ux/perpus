@extends('partials._app')
@section('content')
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
                <img class="wd-70 rounded-circle" src="https://via.placeholder.com/100x100" alt="profile" >
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
                        <h6 class="card-title mb-0">About</h6>
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
                    <div class="mt-3">
                        <label class="tx-11 fw-bolder mb-0 text-uppercase">Alamat:</label>
                        <p class="text-muted">New York, USA</p>
                    </div>
                    <div class="mt-3">
                        <label class="tx-11 fw-bolder mb-0 text-uppercase">Email:</label>
                        <p class="text-muted">me@nobleui.com</p>
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
