<?php

namespace App\Http\Controllers;

use App\Http\Requests\MitraRequest;
use App\Service\MitraService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MitraController extends Controller
{
    protected $MitraService;
    public function __construct(MitraService $MitraService)
    {
        $this->MitraService = $MitraService;
    }
    // get 1 data mitra===================================================================================================
    public function getMitra(Request $r){
        $res = $this->MitraService->getOneMitra($r->mid);
        return response()->json($res);
    }
    // index di page admin===================================================================================================
    public function index_admin_mitra(){
        return view('admin.mitra.index');
    }
    // data mitra============================================================================================================
    public function data_mitra_admin(){
        $results = $this->MitraService->data_mitra();
        return DataTables::eloquent($results)
                ->addIndexColumn()
                ->toJson();
    }
    // store mitra in admin page==================================================================================
    public function store_mitra_admin(MitraRequest $r){
        $r->validated();
        return $this->MitraService->store_mitra($r);
    }
    // update mitra===============================================================================================
    public function update_mitra(Request $r){
        $r->validate([
            //
        ],[
            //
        ]);
        return $this->MitraService->update($r);
    }
}
