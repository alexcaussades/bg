<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            $user = auth()->user();
            $user = User::where('email', $request->email)->first();
            $verify = Hash::check($request->password, $user->password);
            if ($verify) {
                $token_set = $this->create_token();
                DB::table('personal_access_tokens')->insert([
                    'token' => $token_set,
                    'tokenable_id' => $user->id,
                    'tokenable_type' => 'App\Models\User',
                    'name' => 'authToken',
                    'abilities' => '["*"]',
                    'last_used_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                Cookie::queue('authToken', $token_set, 43200);
            }else{
                return response()->json([
                    'message' => 'Unauthorized'
                ], 401);
            }
        }

        return response()->json([
            'message' => 'Unauthorized'
        ], 401);
    }

    public function checktoken(){
        $token = Cookie::get('authToken');
        if ($token) {
            $tt = DB::table('personal_access_tokens')->where('token', $token)->first();
            if ($tt) {
                Auth::loginUsingId($tt->tokenable_id);
                // set last_used_at to current time when token is used
                DB::table('personal_access_tokens')->where('token', $token)->update(['last_used_at' => now()]);
                return view('home');
            }
        }
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|max:28|regex:/[a-z]/|regex:/[A-Z]{1}/|regex:/[0-9]{1,2}/|regex:/[@$!%*#?&]{1}/'
        ]);

        $checkusers = User::where('email', $request->email)->first();
        if ($checkusers) {
            return response()->json([
                'message' => 'Email already exists'
            ], 400);
        }

        $checkusersName = User::where('name', $request->name)->first();
        if ($checkusersName) {
            return response()->json([
                'message' => 'Name already exists'
            ], 400);
        }

        if ($request->password != $request->password_confirmation) {
            return response()->json([
                'message' => 'Password does not match'
            ], 400);
        }

        if ($request->password === $request->password_confirmation) {
            $data['password'] = Hash::make($data['password']);
            $user = User::create($data);
            return $user;
        }

    }

    public function logout()
    {
        Auth::logout();
        return view("home");
    }

    public function create_token(){
        $user = Auth::user();
        $token = Str::uuid();
        return $token;
    }
}
