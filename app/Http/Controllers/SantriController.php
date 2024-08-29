<?php

namespace App\Http\Controllers;

use App\Http\Requests\SantriRequest;
use App\Models\Asrama;
use App\Models\Santri;
use App\Service\SantriService;
use App\Service\SettingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    // santri update============================================================================================================
    public function santri_update(Request $req){
        //
    }

    // santri delete============================================================================================================
    public function delete_santri(Request $r){
        return $this->SantriService->delete($r->sid);
    }

    // santri import============================================================================================================
    public function import_santri(Request $r){
        $r->validate([
            'file_santri' => 'required|file|mimes:xlsx,xls|max:2048',
        ],[
            'file_santri.required' => 'File tidak boleh kosong',
            'file_santri.file' => 'File harus berupa file excel',
            'file_santri.mimes' => 'File harus berupa file excel',
            'file_santri.max' => 'File tidak boleh melebihi 2MB',
        ]);
        return $this->SantriService->import($r);
    }

    // generate user multi============================================================================================================
    public function generate_user(Request $r){
        return $this->SantriService->generateUser($r);
    }
    // generate user one============================================================================================================
    public function generate_user_one(Request $r){
        return $this->SantriService->generateUserOne($r);
    }

    // export santri============================================================================================================
    public function export_santri(Request $r){
        return $this->SantriService->export($r);
    }

    // halaman santri dashboard
    public function index_santri(){
        $data = Santri::where('user_id', Auth::user()->id)->first();
        return view('santri.dashboard', compact('data'));
    }

}
