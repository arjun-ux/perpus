<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
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
    // index
    public function index(){
        return view('admin.users.index');
    }
    // data
    public function data_user(){
        $results = $this->UserService->data_user();
        return DataTables::of($results)
                ->addIndexColumn()
                ->toJson();
    }
    //data id
    public function user_id(Request $request) {
        return $this->UserService->getById($request->id);
    }
    // user update
    public function user_update(UserRequest $request) {
        $request->validated();
        return $this->UserService->update($request);
    }
    // session index
    public function sesi(){
        return view('admin.users.sesi');
    }
    // data sesi with datatable
    public function data_sesi(){
        $data = $this->UserService->data_session();
        return DataTables::of($data)
                ->addIndexColumn()
                ->toJson();
    }
    //delete sesion
    public function delete_sesi(Request $request){
        DB::table('sessions')->where('id', $request->sessionId)->delete();
        return response()->json(['message'=>'Berhasil Delete Sesi']);
    }
}
