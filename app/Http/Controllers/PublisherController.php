<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use App\Service\PublisherService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PublisherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('publisher.index');
    }

    /**
     * Show the form for data a new resource.
     */
    public function data()
    {
        $data = PublisherService::data_publisher();
        return DataTables::eloquent($data)
                ->addIndexColumn()
                ->toJson();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $req)
    {
        $req->validate([
            'name' => 'required',
        ],[
            'name.required' => 'Nama Penerbit Wajib Diisi',
        ]);
        return PublisherService::store_publisher($req);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $req)
    {
        return Publisher::where('id', $req->pid)->first();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $req)
    {
        $req->validate([
            'name' => 'required',
        ],[
            'name.required' => 'Nama Penerbit Wajib Diisi',
        ]);
        return PublisherService::update_publisher($req);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $req)
    {
        return PublisherService::delete_publisher($req);
    }
}
