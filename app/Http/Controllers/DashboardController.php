<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Service\BorrowService;
use App\Service\BukuService;
use App\Service\ReturnService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // index============================================================================================================
    public function index(){
        $haveSet = Setting::first();
        $jml_buku = BukuService::stock_buku();
        $jml_peminjam = BorrowService::jml_peminjam();
        $jml_return = ReturnService::jml_pengembalian();

        $data = [
            'set' => $haveSet,
            'jml_buku' => $jml_buku,
            'jml_peminjam' => $jml_peminjam,
            'jml_return' => $jml_return,
        ];
        // dd($data);
        return view('admin.dashboard', compact('data'));
    }
}
