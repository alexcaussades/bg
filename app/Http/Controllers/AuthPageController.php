<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthPageController extends Controller
{
    private AuthController $auth;

    public function __construct(AuthController $auth)
    {
        $this->auth = $auth;
    }

    public function login(Request $request)
    {
        if ($request->cookie('authToken')) {
            $this->auth->checktoken();
            return redirect()->route('home');
        }

        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function cgu()
    {
        return view('cgu');
    }

    public function registerStore(Request $request)
    {
        $this->auth->register($request);
        return redirect()->route('login');
    }

    public function loginStore(Request $request)
    {
        $this->auth->login($request);
        return redirect()->route('home');
    }

    public function logout()
    {
        $this->auth->logout();
        return redirect()->route('home');
    }

    public function account()
    {
        return view('auth.my-account', [
            'user' => $this->auth->my_account(),
        ]);
    }
}
