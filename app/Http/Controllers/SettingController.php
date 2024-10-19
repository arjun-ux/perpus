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
        $request->validate([
            'lembaga' => 'required',
            'address' => 'required',
            'borrowing_due' => 'required',
            'denda' => 'required',
            'denda_hilang' => 'required',
            'file' => 'required|mimes:png,jpg',
        ],[
            'lembaga.required' => 'Lembaga Wajib Di Isi',
            'address.required' => 'Alamat Wajib Di Isi',
            'borrowing_due.required' => 'Masa Peminjaman Wajib Di Isi',
            'denda.required' => 'Denda Wajib Di Isi',
            'denda_hilang.required' => 'Denda Buku Hilang Wajib Di Isi',
            'file.required' => 'File Wajib Di Isi',
            'file.mimes' => 'File Harus Berupa PNG atau JPG',
        ]);

        $denda = str_replace(['Rp. ', '.', ' '], '', $request->input('denda'));
        $denda = (int)$denda;
        $denda_hilang = str_replace(['Rp. ', '.', ' '], '', $request->input('denda_hilang'));
        $denda_hilang = (int)$denda_hilang;

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
                'denda_hilang' => $denda_hilang,
                'image' => $path,
            ]);

            return response()->json(['message' => 'Berhasil Setting Aplikasi'],200);
        }else {
            return response()->json(['message' => 'Logo Lembaga Mohon Di Isi'],404);
        }
    }
    // edit
    public function edit(){
        $setting = Setting::first();
        return view('settings.edit', compact('setting'));
    }
    // update
    public function update(Request $req){
        $req->validate([
            'lembaga' => 'required',
            'address' => 'required',
            'borrowing_due' => 'required',
            'denda' => 'required',
        ],[
            'lembaga.required' => 'Lembaga Wajib Di Isi',
            'address.required' => 'Alamat Wajib Di Isi',
            'borrowing_due.required' => 'Masa Peminjaman Wajib Di Isi',
            'denda.required' => 'Denda Wajib Di Isi',
        ]);

        $denda = str_replace(['Rp. ', '.', ' '], '', $req->input('denda'));
        $denda = (int)$denda;
        $denda_hilang = str_replace(['Rp. ', '.', ' '], '', $req->input('denda_hilang'));
        $denda_hilang = (int)$denda_hilang;

        if ($req->hasFile('file')) {
            $setting = Setting::first();
            if (file_exists(public_path($setting->image))) {
                unlink(public_path($setting->image)); // Hapus file lama
            }

            $file = $req->file('file');
            $name = "logo_" . now()->timestamp;
            $path = $file->storeAs('public/logo', $name . '.' . $file->getClientOriginalExtension());

            $setting->update([
                'lembaga' => $req->lembaga,
                'address' => $req->address,
                'borrowing_due' => $req->borrowing_due,
                'denda' => $denda,
                'denda_hilang' => $denda_hilang,
                'image' => $path,
            ]);

            return response()->json(['message' => 'Berhasil Memperbarui E-Perpus']);
        }else {
            // update tanpa file
            $setting = Setting::first();
            $setting->update([
                'lembaga' => $req->lembaga,
                'address' => $req->address,
                'borrowing_due' => $req->borrowing_due,
                'denda' => $denda,
                'denda_hilang' => $denda_hilang,
            ]);

            return response()->json(['message' => 'Berhasil Update E-Perpus']);
        }
        return response()->json(['message' => 'Terjadi Kesalahan Update Data'],500);
    }

}
