<?php

namespace App\Http\Controllers;

use App\Models\Books;
use App\Models\Category;
use App\Models\Publisher;
use App\Service\BukuService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BukuController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $publishers = Publisher::all();
        $categorys = Category::all();
        return view('buku.index', compact('publishers', 'categorys'));
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
                return $data->publisher ? $data->publisher->name : 'Tidak tersedia';
            })
            ->toJson();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $req)
    {
        $req->validate([
            'title' => 'required',
            'author' => 'required',
            'publisher_id' => 'required',
            'category_id' => 'required',
            'isbn' => 'required',
            'publish_date' => 'required',
            'stock_rusak' => 'required',
            'stock_baik' => 'required',
        ],[
            'title.required' => 'Judul Buku Wajib Diisi',
            'author.required' => 'Penulis Buku Wajib Diisi',
            'publisher_id.required' => 'Penerbit Buku Wajib Diisi',
            'category_id.required' => 'Kategori Buku Wajib Diisi',
            'isbn.required' => 'ISBN Buku Wajib Diisi',
            'publish_date.required' => 'Tanggal Terbit Buku Wajib Diisi',
            'stock_rusak.required' => 'Stok Rusak Buku Wajib Diisi',
            'stock_baik.required' => 'Stok Baru Buku Wajib Diisi',
        ]);

        return BukuService::save_book($req);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $req)
    {
        $data = Books::where('id', $req->bid)->first();
        if ($data) {
            return response()->json($data);
        }
        return response()->json(['message' => 'Data tidak ditemukan'], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $req)
    {
        $req->validate([
            'title' => 'required',
            'author' => 'required',
            'publisher_id' => 'required',
            'category_id' => 'required',
            'isbn' => 'required',
            'publish_date' => 'required',
            'stock_rusak' => 'required',
            'stock_baik' => 'required',
        ],[
            'title.required' => 'Judul Buku Wajib Diisi',
            'author.required' => 'Penulis Buku Wajib Diisi',
            'publisher_id.required' => 'Penerbit Buku Wajib Diisi',
            'category_id.required' => 'Kategori Buku Wajib Diisi',
            'isbn.required' => 'ISBN Buku Wajib Diisi',
            'publish_date.required' => 'Tanggal Terbit Buku Wajib Diisi',
            'stock_rusak.required' => 'Stok Rusak Buku Wajib Diisi',
            'stock_baik.required' => 'Stok Baru Buku Wajib Diisi',
        ]);
        return BukuService::update_book($req);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $req)
    {
        return BukuService::delete_buku($req);
    }
}
