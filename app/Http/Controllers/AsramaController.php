<?php

namespace App\Http\Controllers;

use App\Service\SettingService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AsramaController extends Controller
{
    protected $Settings;
    public function __construct(SettingService $Settings)
    {
        $this->Settings = $Settings;
    }
    //get by id=====================================================================================
    public function getId(Request $r){
        // aid = asrama id
        return $this->Settings->getOneAsrama($r->aid);
    }
    // index=====================================================================================
    public function index(){
        return view('admin.asrama.index');
    }
    // data asrama=====================================================================================
    public function dataAsrama(){
        $res = $this->Settings->data_asrama();
        return DataTables::eloquent($res)
                ->addIndexColumn()
                ->toJson();
    }
    // simpan asrama=====================================================================================
    public function simpan_asrama(Request $req){
        $req->validate(['nama_asrama'=>'required'],['nama_asrama'=>'Nama Asrama Wajib di isi']);
        return $this->Settings->simpan($req);
    }
    // update asrama=====================================================================================
    public function update_asrama(Request $req){
        $req->validate(['nama_asrama'=>'required'],['nama_asrama'=>'Nama Asrama Wajib di isi']);
        return $this->Settings->update($req);
    }
    // delete asrama=====================================================================================
    public function delete_asrama(Request $r){
        $r->validate(['aid'=>'required']);
        return $this->Settings->delete($r->aid);
    }
}
