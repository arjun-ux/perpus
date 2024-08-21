@extends('partial1._app')
@section('content')
<div class="page-content">

    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">Selamat Datang</h4>
        </div>
        <div class="d-flex align-items-center flex-wrap text-nowrap">
            <button type="button" class="btn btn-outline-primary btn-icon-text me-2 mb-2 mb-md-0">
                <i class="btn-icon-prepend" data-feather="printer"></i>
                Print
            </button>
        </div>
    </div>
    <div class="row">
        @if (session('success_login'))
            <div class="alert alert-success" role="alert">
                <h5>{{ session('success_login') }}, <strong>{{ Auth::user()->name }}</strong></h5>
            </div>
        @endif
    </div>

</div>
@endsection
