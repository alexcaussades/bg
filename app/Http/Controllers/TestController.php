<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cookie;

class TestController extends Controller
{
    public function test()
    {
        return view('test');
    }
}
