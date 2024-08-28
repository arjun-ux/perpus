@extends('partials._app')
@section('content')
    <div class="page-content">
        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
            <div>
                <h4 class="mb-3 mb-md-0">Create Santri / Mahasiswa</h4>
            </div>
            <div class="d-flex align-items-center flex-wrap text-nowrap">

            </div>
        </div>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('santri.store') }}" method="POST">
                            @csrf
                            <div class="row mb-3">
                                <div class="col">
                                    <label class="form-label">NIM :</label>
                                    <input class="form-control mb-4 mb-md-0" name="nim" placeholder="NIM" value="{{ old('nim') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">NIUP :</label>
                                    <input class="form-control" name="niup" placeholder="NIUP" value="{{ old('niup') }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">NAMA LENGKAP :</label>
                                    <input class="form-control mb-4 mb-md-0" name="nama_lengkap" placeholder="NAMA LENGKAP" value="{{ old('nama_lengkap') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">JENIS KELAMIN :</label>
                                    <select class="form-select" name="jenis_kelamin">
                                        <option selected disabled>Pilih Jenis Kelamin</option>
                                        <option value="L">Laki - Laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">TEMPAT LAHIR :</label>
                                    <input class="form-control mb-4 mb-md-0" name="tmp_lahir" placeholder="TEMPAT LAHIR" value="{{ old('tmp_lahir') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">TANGGAL LAHIR :</label>
                                    <div class="input-group flatpickr  me-2 mb-2 mb-md-0 " id="dashboardDate">
                                        <input type="text" class="form-control bg-transparent flatpickr-input" placeholder="Pilih Tanggal" data-input name="tgl_lahir">
                                        <span class="input-group-text input-group-addon bg-transparent" data-toggle><i data-feather="calendar" class="text-primary"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">SKILL (Optional) :</label>
                                    <input class="form-control mb-4 mb-md-0" name="skill" placeholder="SKILL" value="{{ old('skill') }}"/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">NO TLPN ORANG TUA :</label>
                                    <input class="form-control" name="no_ortu" placeholder="NO TELEPON ORANG TUA" value="{{ old('no_ortu') }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">ID TELEGRAM (Optional) :</label>
                                    <input class="form-control mb-4 mb-md-0" name="id_telegram" placeholder="ID TELEGRAM" value="{{ old('id_telegram') }}"/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">ASRAMA :</label>
                                    <select class="form-select" name="asrama_id">
                                        <option selected disabled>Pilih Asrama</option>
                                        @foreach ($asrama as $val)
                                            <option value="{{ $val->id }}">{{ $val->nama_asrama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">PROGRAM STUDI :</label>
                                    <select class="form-select" name="prodi_id">
                                        <option selected disabled>Pilih Program Studi</option>
                                        @foreach ($prodi as $val)
                                            <option value="{{ $val->id }}">{{ $val->nama_prodi }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">EMAIL :</label>
                                    <input class="form-control" name="email" placeholder="EMAIL" value="{{ old('email') }}">
                                </div>
                            </div>
                            <button type="submit" name="action" value="save" class="btn btn-primary me-2">Simpan</button>
                            <button type="submit" name="action" value="save_create" class="btn btn-info me-2">Save & Create</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error('{{ $error }}')
            @endforeach
        @endif
        @if (session('success'))
            toastr.success('{{ session('success') }}');
        @endif
    </script>
@endpush
