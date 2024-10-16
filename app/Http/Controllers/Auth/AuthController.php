<?php

namespace App\Http\Controllers\Auth;

use App\Service\AuthService;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Models\Setting;
use App\Service\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $AuthService;
    protected $Admin;
    protected $Santri;
    protected $Mitra;
    public function __construct(AuthService $AuthService, UserService $Admin){
        $this->AuthService = $AuthService;
        $this->Admin = $Admin;
    }
    //login===================================================================================================
    public function index(){
        $haveSet = Setting::first();
        $sudahSet = false;
        if ($haveSet) {
            $sudahSet = true;
            return view('auth.login',compact('sudahSet', 'haveSet'));
        }
        return view('auth.login',compact('sudahSet', 'haveSet'));

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
}
