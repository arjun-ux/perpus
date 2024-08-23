<?php

namespace App\Http\Controllers;

use App\Service\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    protected $UserService;
    public function __construct(UserService $UserService)
    {
        $this->UserService = $UserService;
    }
    // index============================================================================================================
    public function index(){
        return view('admin.users.index');
    }
    // data============================================================================================================
    public function data_user(){
        $res = $this->UserService->data_user();
        return DataTables::of($res)
                ->addIndexColumn()
                ->toJson();
    }
    //data id============================================================================================================
    public function user_id(Request $req) {
        return $this->UserService->getById($req->id);
    }
    // user update============================================================================================================
    public function user_update(Request $req) {
        $req->validate([
            'name' => 'required',
            'username' => 'required',
            'email' => 'required',
            'role' => 'required',
        ],[
            "name.required" => 'Nama Wajib diisi',
            "username.required" => 'Usename Wajib diisi',
            "email.required" => 'Email Wajib diisi',
            "role.required" => 'Role Wajib diisi',
        ]);
        return $this->UserService->update($req);
    }
    // delete user============================================================================================================
    public function delete_user(Request $req){
        return $this->UserService->delete($req);
    }
    // session index============================================================================================================
    public function sesi(){
        return view('admin.users.sesi');
    }
    // data sesi with datatable============================================================================================================
    public function data_sesi(){
        $data = $this->UserService->data_session();
        return DataTables::of($data)
                ->addIndexColumn()
                ->toJson();
    }
    //delete sesion============================================================================================================
    public function delete_sesi(Request $request){
        DB::table('sessions')->where('id', $request->sessionId)->delete();
        return response()->json(['message'=>'Berhasil Delete Sesi']);
    }
}
