<?php

namespace App\Http\Controllers;

use App\Service\BukuService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BukuController extends Controller
{
    protected $Buku;
    public function __construct(BukuService $Buku)
    {
        return $this->Buku = $Buku;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('buku.index');
    }

    /**
     * Show the form for data a new resource.
     */
    public function data()
    {
        $data = BukuService::data_buku();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('penerbit',function($data){
                return $data->publisher->name;
            })
            ->toJson();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $req)
    {
        return BukuService::delete_buku($req);
    }
}
