<?php

namespace App\Http\Controllers;

use App\Http\Requests\MagangRequest;
use App\Service\MagangService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MagangController extends Controller
{
    protected $Magang;
    public function __construct(MagangService $Magang){
        $this->Magang = $Magang;
    }

    // index============================================================================================================
    public function getId(Request $r){
        return $this->Magang->getOne($r->mid);
    }
    // index============================================================================================================
    public function index(){
        return view('admin.magang.index');
    }
    // data============================================================================================================
    public function data(){
        $res =  $this->Magang->getAll();
        return DataTables::eloquent($res)
            ->addIndexColumn()
            ->toJson();
    }
    // create ============================================================================================================
    public function magang_store(MagangRequest $req){
        $req->validated();
        return $this->Magang->store($req);
    }
    // update magang ============================================================================================================
    public function magang_update(MagangRequest $req){
        $req->validated();
        return $this->Magang->update($req);
    }
    // delete ============================================================================================================
    public function magang_delete(Request $r){
        return $this->Magang->delete($r->mid);
    }


    // halaman magang santri ============================================================================================================
    public function index_santri(){
        return view('santri.magang.index');
    }
}
