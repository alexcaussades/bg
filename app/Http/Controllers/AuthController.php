<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // public function login(Request $request)
    // {
    //     $credentials = $request->only('email', 'password');

    //     if (auth()->attempt($credentials)) {
    //         $user = auth()->user();
    //         $token = $user->createToken('authToken')->accessToken;

    //         return response()->json([
    //             'token' => $token,
    //             'user' => $user
    //         ]);
    //     }

    //     return response()->json([
    //         'message' => 'Unauthorized'
    //     ], 401);
    // }

    // public function logout(Request $request)
    // {
    //     $request->user()->token()->revoke();

    //     return response()->json([
    //         'message' => 'Successfully logged out'
    //     ]);
    // }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|max:28|regex:/[a-z]/|regex:/[A-Z]{1}/|regex:/[0-9]{1,2}/|regex:/[@$!%*#?&]{1}/'
        ]);

        $data['password'] = Hash::make($data['password']);

        dd($data);
    }
}
