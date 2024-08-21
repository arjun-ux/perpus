<?php

namespace App\Http\Controllers;

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
    // index di page admin
    public function index_admin_mitra(){
        return view('admin.mitra.index');
    }
    // data mitra
    public function data_mitra(){
        $results = $this->MitraService->data_mitra();
        return DataTables::eloquent($results)
                ->addIndexColumn()
                ->toJson();
    }
}
