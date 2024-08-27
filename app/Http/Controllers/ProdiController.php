<?php

namespace App\Http\Controllers;

use App\Service\SettingService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProdiController extends Controller
{
    protected $Setting;
    public function __construct(SettingService $set)
    {
        $this->Setting = $set;
    }
    // getID=================================================================================================
    public function getId(Request $r){
        $res = $this->Setting->getOneProdi($r->pid);
        return response()->json($res);
    }
    // index=================================================================================================
    public function index(){
        return view('admin.prodi.index');
    }
    // data=================================================================================================
    public function data(){
        $res = $this->Setting->data_prodi();
        return DataTables::eloquent($res)
                ->addIndexColumn()
                ->toJson();
    }
    // store=================================================================================================
    public function simpan_prodi(Request $r){
        $r->validate(['nama_prodi'=> 'required'],['nama_prodi.required' => 'Nama Wajib Di Isi']);
        $res = $this->Setting->store($r->all());
        return response()->json($res);
    }
    // update=================================================================================================
    public function update_prodi(Request $r){
        //
    }
    // delete=================================================================================================
    public function delete_prodi(Request $r){
        //
    }
}
