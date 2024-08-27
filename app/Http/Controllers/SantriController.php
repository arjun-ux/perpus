<?php

namespace App\Http\Controllers;

use App\Http\Requests\SantriRequest;
use App\Models\Asrama;
use App\Service\SantriService;
use App\Service\SettingService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SantriController extends Controller
{
    protected $SantriService;
    protected $Setting;
    public function __construct(SantriService $SantriService, SettingService $Setting)
    {
        $this->SantriService = $SantriService;
        $this->Setting = $Setting;
    }
    // index page admin============================================================================================================
    public function index_admin(){
        return view('admin.santri.index');
    }
    // data index page admin============================================================================================================
    public function data_santri(){
        $results = $this->SantriService->data();
        return DataTables::eloquent($results)
            ->addIndexColumn()
            ->toJson();
    }
    // Santri create page admin============================================================================================================
    public function create(){
        $asrama = $this->Setting->data_asrama()->get();
        $prodi = $this->Setting->data_prodi()->get();
        return view('admin.santri.create', compact('asrama','prodi'));
    }
    // santri store============================================================================================================
    public function santri_store(SantriRequest $req){
        $req->validated();
        return $this->SantriService->store($req);
    }





    // santri delete============================================================================================================
    public function delete_santri(Request $r){
        return $this->SantriService->delete($r->sid);
    }
}
