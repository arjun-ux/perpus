<?php

namespace App\Http\Controllers;

use App\Http\Requests\PembinaRequest;
use App\Service\PembinaService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PembinaController extends Controller
{
    protected $Pembina;
    public function __construct(PembinaService $Pembina)
    {
        $this->Pembina = $Pembina;
    }
    // get id pembina============================================================================================================
    public function getId(Request $req){
        return $this->Pembina->get_one($req->pid);
    }
    // index pembina============================================================================================================
    public function index(){
        return view('admin.pembina.index');
    }
    // data-pembina============================================================================================================
    public function data_pembina(){
        $res = $this->Pembina->data_all();
        return DataTables::eloquent($res)
                ->addIndexColumn()
                ->toJson();
    }
    // store pembina============================================================================================================
    public function store(PembinaRequest $r){
        $r->validated();
        return $this->Pembina->store_pembina_with_user($r);
    }
    // update pembina============================================================================================================
    public function update(Request $r){
        // $r->validate();
        return $this->Pembina->update_pembina($r);
    }
    // delete pembina============================================================================================================
    public function delete(Request $r){
        return $this->Pembina->delete_pembina($r);
    }

}
