<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    //index
    public function index() {
        $haveSet = Setting::first();
        $sudahSet = false;
        if ($haveSet) {
            $sudahSet = true;
            return view('settings.index', compact('sudahSet','haveSet'));
        }
        return view('settings.index', compact('sudahSet','haveSet'));
    }
    // create
    public function create(){
        return view('settings.create');
    }
    // simpan
    public function store(Request $request){
        $denda = str_replace(['Rp. ', '.', ' '], '', $request->input('denda'));
        $denda = (int)$denda;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $name = "logo_" . now()->timestamp;
            $path = $file->storeAs('public/logo', $name . '.' . $file->getClientOriginalExtension());

            // save db
            Setting::create([
                'lembaga' => $request->lembaga,
                'address' => $request->address,
                'borrowing_due' => $request->borrowing_due,
                'denda' => $denda,
                'image' => $path,
            ]);

            return response()->json(['message' => 'Berhasil Setting Aplikasi'],200);
        }else {
            return response()->json(['message' => 'Logo Lembaga Mohon Di Isi'],404);
        }
    }
    // edit
    public function edit(){
        return view('settings.edit');
    }
    // update
    public function update(){
        //
    }
}
