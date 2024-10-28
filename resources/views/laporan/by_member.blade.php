
<html>
    <head>
        <title>Laporan Perpustakaan - Berdasarkan Member</title>
        <!-- End fonts -->

        <!-- core:css -->
        <link rel="stylesheet" href="{{ asset('assets/vendors/core/core.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/fonts/feather-font/css/iconfont.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/vendors/flag-icon-css/css/flag-icon.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/light/style.css') }}">
        <!-- End layout styles -->



    </head>
    <body style='font-family: Quicksand, sans-serif'>
        <img src='{{ isset($setting) && $setting->image ? asset('storage/logo/' . basename($setting->image)) : asset('assets/images/logo.png') }}' style='height: 90px; width: 90px; margin-top: 10px; margin-left: 10px; margin-bottom: -50px;'>
        <img src='{{ asset('assets/images/LOGO-PERPUSNAS.png') }}' style='display: block; margin-left: auto; width: 90px; margin-bottom: -70px; margin-top: -38px; margin-right: 5px;'>
        <h3 class='text-center' style='font-family: Quicksand, sans-serif; margin-top: -30px;'>.:: Laporan Perpustakaan ::.</h3>
        <p style='font-size: 12px;' class='text-center'>SMP Unggulan Al-Anwari<br> Kertosari Banyuwangi </p>
        <hr>
        <div class="p-2" id="buttonTool">
            <a href="{{ route('laporan.index') }}" class="btn btn-outline-warning">Cancel</a>
            <button type="button" id="printPage" class="btn btn-outline-primary btn-icon-text me-2 mb-2 mb-md-0">
                <i class="btn-icon-prepend" data-feather="printer"></i> Print
            </button>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered" style="width: 100%;">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>NAMA MEMBER</th>
                        <th>JUDUL BUKU</th>
                        <th>TANGGAL PEMINJAMAN</th>
                        <th>TANGGAL PENGEMBALIAN</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($datas as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name ?? 'N/A' }}</td>
                            <td>{{ $item->book_title ?? 'N/A' }}</td>
                            <td>{{ $item->borrow_date ?? 'N/A' }}</td>
                            <td>{{ $item->returned_date ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>



        <!-- core:js -->
        <script src="{{ asset('assets/vendors/core/core.js') }}"></script>
        <script src="{{ asset('assets/vendors/feather-icons/feather.min.js') }}"></script>
        <script src="{{ asset('assets/js/dashboard-light.js') }}"></script>
        <script>
            feather.replace();

            document.getElementById('printPage').addEventListener('click', function() {
                document.getElementById('buttonTool').style.display = 'none';
                window.print();
                document.getElementById('buttonTool').style.display = 'block';
            });


        </script>
    </body>
</html>
