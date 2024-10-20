
<html>
    <head>
        <title>Laporan Perpustakaan - Tanggal Peminjaman</title>
        <!-- End fonts -->

        <!-- core:css -->
        <link rel="stylesheet" href="{{ asset('assets/vendors/core/core.css') }}">
        <!-- endinject -->
        <link rel="stylesheet" href="{{ asset('assets/vendors/datatables.net-bs5/dataTables.bootstrap5.css') }}">
        <!-- End plugin css for this page -->
        <!-- stack css -->
        <!-- endinject -->

        <!-- Layout styles -->
        <link rel="stylesheet" href="{{ asset('assets/css/light/style.css') }}">
        <!-- End layout styles -->
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}"/>


    </head>
    <body onload='window.print()' style='font-family: Quicksand, sans-serif'>
        <img src='{{ isset($setting) && $setting->image ? asset('storage/logo/' . basename($setting->image)) : asset('assets/images/logo.png') }}' style='height: 90px; width: 90px; margin-top: 10px; margin-left: 10px; margin-bottom: -50px;'>
        <img src='{{ asset('assets/images/LOGO-PERPUSNAS.png') }}' style='display: block; margin-left: auto; width: 90px; margin-bottom: -70px; margin-top: -38px; margin-right: 5px;'>
        <h3 class='text-center' style='font-family: Quicksand, sans-serif; margin-top: -30px;'>.:: Laporan Perpustakaan ::.</h3>
        <p style='font-size: 12px;' class='text-center'>SMP Unggulan Al-Anwari<br> Kertosari Banyuwangi </p>
        <hr>
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
                            <td>{{ $item->member->user->name }}</td>
                            <td>{{ $item->book->title }}</td>
                            <td>{{ $item->borrow_date }}</td>
                            <td>{{ $item->returned_date }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <p style='text-align: center;'>Laporan Perpustakaan Berdasarkan Tanggal Peminjaman ({{ $datas['0']->borrow_date }})</p>


    <!-- core:js -->
    <script src="{{ asset('assets/vendors/core/core.js') }}"></script>
    <!-- endinject -->

    <!-- Plugin js for this page -->
    <script src="{{ asset('assets/vendors/datatables.net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/vendors/datatables.net-bs5/dataTables.bootstrap5.js') }}"></script>

    <!-- inject:js -->
    <script src="{{ asset('assets/js/template.js') }}"></script>
    <!-- endinject -->

    <!-- Custom js for this page -->
    <script src="{{ asset('assets/js/dashboard-light.js') }}"></script>
    <script src="{{ asset('assets/js/data-table.js') }}"></script>
    </body>
</html>
