<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\User;
use App\Service\BorrowService;
use App\Service\BukuService;
use App\Service\MemberService;
use App\Service\ReturnService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends Controller
{
    // index============================================================================================================
    public function index(){
        $haveSet = Setting::first();
        $jml_buku = BukuService::jumlah_buku();
        $stok_buku = BukuService::stock_buku();
        $buku_hilang = BukuService::buku_hilang();
        $jml_peminjam = BorrowService::jml_peminjam();
        $jml_return = ReturnService::jml_pengembalian();

        $data = [
            'set' => $haveSet,
            'jml_buku' => $jml_buku,
            'stok_buku' => $stok_buku,
            'buku_hilang' => $buku_hilang,
            'jml_peminjam' => $jml_peminjam,
            'jml_return' => $jml_return,
        ];
        // dd($buku_hilang);
        return view('admin.dashboard', compact('data'));
    }
    // laporan
    public function laporan(){
        return view('laporan.index');
    }
    // data laporan by tgl peminjaman
    public function by_tgl_peminjaman(Request $req){
        $setting = Setting::first();
        $datas = BorrowService::get_by_tgl_peminjaman($req->tgl);
        // dd($datas);
        if ($datas == null) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }
        return view('laporan.tgl_peminjaman', compact('datas','setting'));
    }
    // data laporan by tgl pengembalian
    public function by_tgl_pengembalian(Request $req){
        $setting = Setting::first();
        $datas = BorrowService::get_by_tgl_pengembalian($req->tgl);

        if ($datas == null) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }
        return view('laporan.tgl_pengembalian', compact('datas','setting'));
    }

    // get user member
    public static function cari_member(Request $request){
        $query = $request->get('q'); // Mendapatkan kata kunci pencarian
        // Validasi input, jika perlu
        if (empty($query)) {
            return response()->json(['data' => []]);
        }
        $member = User::with('member')->where('name', 'LIKE', "%{$query}%")->paginate(5);
        return response()->json($member);
    }
    // data laporan by anggota
    public function by_member(Request $req)
    {
        $setting = Setting::first();
        $datas = BorrowService::get_by_anggota($req->member);


        return view('laporan.by_member', compact('setting', 'datas'));
    }
}
