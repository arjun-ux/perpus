<?php

namespace App\Http\Controllers\Auth;

use App\Service\AuthService;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use Illuminate\Http\Request;


class AuthController extends Controller
{
    protected $AuthService;
    public function __construct(AuthService $AuthService){
        $this->AuthService = $AuthService;
    }
    //login
    public function index(){
        return view('auth.login');
    }
    // dologin
    public function dologin(AuthRequest $request){
        $cred = $request->validated();
        return $this->AuthService->do_login($cred);
    }
    // logout
    public function logout(Request $request)
    {
        return $this->AuthService->do_logout($request);
    }

    // profile yang terauth
    public function profile(){
        return view('admin.settings.profile');
    }
}
