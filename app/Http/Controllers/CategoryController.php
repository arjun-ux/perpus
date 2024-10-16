<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Service\CategoryService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('category.index');
    }

    /**
     * Show the form for datatable a new resource.
     */
    public function data()
    {
        $data = CategoryService::data_category();
        return DataTables::eloquent($data)
                ->addIndexColumn()
                ->toJson();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ],[
            'name.required' => 'Nama Kategori tidak boleh kosong',
        ]);
        return CategoryService::store_category($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $req)
    {
        return Category::where('id', $req->id)->first();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $req)
    {
        return CategoryService::update_category($req);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $req)
    {
        return CategoryService::delete_category($req);
    }
}
