<?php

namespace App\Http\Controllers\Auth;

use App\Service\AuthService;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Models\Mitra;
use App\Models\Santri;
use App\Service\MitraService;
use App\Service\PembinaService;
use App\Service\SantriService;
use App\Service\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $AuthService;
    protected $Admin;
    protected $Santri;
    protected $Mitra;
    public function __construct(AuthService $AuthService, UserService $Admin, SantriService $Santri, PembinaService $Pembina, MitraService $Mitra){
        $this->AuthService = $AuthService;
        $this->Admin = $Admin;
        $this->Santri = $Santri;
        $this->Mitra = $Mitra;
    }
    //login===================================================================================================
    public function index(){
        return view('auth.login');
    }
    // dologin===================================================================================================
    public function dologin(AuthRequest $request){
        $cred = $request->validated();
        return $this->AuthService->do_login($cred);
    }
    // logout===================================================================================================
    public function logout(Request $request)
    {
        return $this->AuthService->do_logout($request);
    }

    // profile yang terauth===================================================================================================
    public function profile(){
        if (Auth::user()->role === 'dev' || Auth::user()->role === 'admin' || Auth::user()->role === 'pembina') {
            return view('admin.settings.profile');
        }elseif (Auth::user()->role === 'santri') {
            $data = Santri::where('user_id', Auth::user()->id)->first();
            // dd($data);
            return view('santri.profile', compact('data'));
        }else {
            $da = Mitra::where('user_id', Auth::user()->id)->first();
            return view('mitra.profile', compact('da'));
        }
    }
    // data diri profile===================================================================================================
    public function data_profile(){
        if (Auth::user()->role === 'dev' || Auth::user()->role === 'admin' || Auth::user()->role === 'pembina') {
            return $this->Admin->get_data_profile();
        }elseif (Auth::user()->role === 'santri') {
            return $this->Santri->get_data_profile();
        }else {
            return $this->Mitra->get_data_profile();
        }
    }
}
