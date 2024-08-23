<?php

namespace App\Http\Controllers;

use App\Service\SantriService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SantriController extends Controller
{
    protected $SantriService;
    public function __construct(SantriService $SantriService)
    {
        $this->SantriService = $SantriService;
    }
    // index page admin============================================================================================================
    public function index_admin(){
        return view('admin.santri.index');
    }
    // data index page admin============================================================================================================
    public function data_santri(){
        $results = $this->SantriService->data_santri();
        return DataTables::eloquent($results)
                ->addIndexColumn()
                ->toJson();
    }
}
