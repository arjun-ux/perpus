@extends('partials._app')
@section('content')

<div class="page-content">

    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        @if ($data['set'] == null)
            <div>
                <h4 class="mb-3 mb-md-0">Selamat Datang di E-Perpus</h4>
            </div>
        @else
            <div>
                <h4 class="mb-3 mb-md-0">Selamat Datang di E-Perpus {{ $data['set']->lembaga }}</h4>
            </div>
        @endif

        <div class="d-flex align-items-center flex-wrap text-nowrap">
        </div>
    </div>
    @if (session('success_login'))
        <div class="alert alert-success">
            <h5>{{ session('success_login') }}, <strong>{{ Auth::user()->name }}</strong></h5>
        </div>
    @endif
    @if ($data['set'] == null)
        <div class="alert alert-danger">
            <h5><strong>Aplikasi Belum Di Setting</strong></h5>
        </div>
    @endif
    <div class="row">
        <div class="col-12 col-xl-12 stretch-card">
            <div class="row flex-grow-1">

                <div class="col-md-4 grid-margin stretch-card" id="card-hover">
                    <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline">
                            <h6 class="card-title mb-3">Buku</h6>
                            <div class="mb-2">
                                <a href="{{ route('book.index') }}"><i class="icon-lg text-muted pb-3px" data-feather="shuffle"></i></a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-12 col-xl-5">
                                <h2 class="mb-2">{{ $data['jml_buku'] }}</h2>
                            </div>
                        <div class="col-6 col-md-12 col-xl-7">
                            <div id="growthChart" class="mt-md-3 mt-xl-0"></div>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="col-md-4 grid-margin stretch-card" id="card-hover">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-3">Peminjaman</h6>
                                <div class="mb-2">
                                    <a href="{{ route('borrow.create') }}"><i class="icon-lg text-muted pb-3px" data-feather="shuffle"></i></a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-12 col-xl-5">
                                    <h2 class="mb-2">{{ $data['jml_peminjam'] }}</h2>
                                </div>
                                <div class="col-6 col-md-12 col-xl-7">
                                    <div id="ordersChart" class="mt-md-3 mt-xl-0"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 grid-margin stretch-card" id="card-hover">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-3">Pengembalian</h6>
                                <div class="mb-2">
                                    <a href="{{ route('returns.create') }}"><i class="icon-lg text-muted pb-3px" data-feather="shuffle"></i></a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-12 col-xl-5">
                                    <h2 class="mb-2">{{ $data['jml_return'] }}</h2>
                                </div>
                                <div class="col-6 col-md-12 col-xl-7">
                                    <div id="customersChart" class="mt-md-3 mt-xl-0"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div> <!-- row -->
</div>
@endsection
