<?php

namespace App\Http\Controllers;

use App\Service\ReturnService;
use Illuminate\Http\Request;

class ReturnsController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('returns.create');
    }

    // ambil data peminjaman
    public function get_borrow(Request $req){
        return ReturnService::get_borrowing($req);
    }

    // store
    public function store(Request $req){

        $req->validate([
            'username' => 'required',
            'condition' => 'required',
            'borrow_id' => 'required',
        ],[
            'username.required' => 'ID Member tidak boleh kosong',
            'condition.required' => 'Kondisi tidak boleh kosong',
            'borrow_id.required' => 'Terjadi Kesalahan peminjaman',
        ]);

        return ReturnService::save_return($req);
    }
}
