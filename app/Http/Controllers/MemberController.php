<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Member;
use App\Service\MemberService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class MemberController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kelas = Kelas::all();
        return view('member.index', compact('kelas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function data_member(){
        $data = MemberService::data();
        // echo json_encode($data);
        // exit();
        return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('username', function($member) {
                    return $member->user ? $member->user->username : '-'; // Ambil nama dari relasi user
                })
                ->addColumn('name', function($member) {
                    return $member->user ? $member->user->name : '-'; // Ambil nama dari relasi user
                })
                ->addColumn('kelas', function($member) {
                    return $member->kelas ? $member->kelas->name : '-'; // Ambil nama kelas dari relasi kelas
                })
                ->toJson();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|min:6',
            'name' => 'required',
            'kelas' => 'required',
        ],[
            'nis.required' => 'Nis tidak boleh Kosong',
            'nis.min' => 'Nis Minimal 6 Karakter',
            'name.required' => 'Nama tidak boleh Kosong',
            'kelas.required' => 'Harap Pilih Kelas',
        ]);
        $data = MemberService::store_member($request);
        return $data;
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $req)
    {
        try {
            $data = Member::with('user', 'kelas')->where('username', $req->id)->first();
            return $data;
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $req)
    {
        $data = MemberService::update_member($req);
        return $data;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $req)
    {

        $data = MemberService::delete_member($req->uid);
        return $data;
    }
}
