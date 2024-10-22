<?php

namespace App\Http\Controllers;

use App\Models\Books;
use App\Models\Borrowing;
use App\Models\Member;
use App\Service\BorrowService;
use App\Service\MemberService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BorrowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('borrow.index');
    }

    // data peminjam
    public function data(){
        $data = BorrowService::data_peminjam();
        return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('member', function($data){
                    return $data->member && $data->member->user ? $data->member->user->name : 'No Name';
                })
                ->addColumn('buku', function($data){
                    return $data->book && $data->book->title ? $data->book->title : 'No Name';
                })
                ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('borrow.create');
    }

    // data buku
    public function getBooks(Request $request){
        $query = $request->get('q'); // Mendapatkan kata kunci pencarian
        $books = Books::where('title', 'LIKE', "%{$query}%")->paginate(5);
        return response()->json($books);
    }

    // cek username dan peminjaman sebelumnya
    public function cek_member_borrowing(Request $req){

        $member = MemberService::getLastBorrowWithDetails($req->username);
        if ($member) {
            return $member;
        }else {
            return response()->json([
                'message' => 'data tidak ditemukan',
            ],404);
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $req)
    {
        $req->validate([
            'username' => 'required',
            'book_id' => 'required',
            'condition' => 'required',
        ],[
            'username.required' => 'Member ID Wajib Diisi',
            'book_id.required' => 'Pilih Buku',
            'condition.required' => 'Pilih kondisi buku',
        ]);

        return BorrowService::borrow_save($req);
    }

}
