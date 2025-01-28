<?php

use App\Models\Debit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\calculeDebitController;
use App\Http\Controllers\DebitController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
})->name('home');


Route::get('/debit', function (Request $request) {
    if($request->has('type') && $request->has('dimension') && $request->has('ms'))
    {
        $debit = new calculeDebitController($request->type, $request->dimension, $request->ms);
        $calculeDebit = $debit->calculeDebit();
        $session = new DebitController();
        $session = $session->orderby(); 
        return view('debit', ['result' => $calculeDebit, 'session' => $session]);
    }
    return view('debit');
})->name('debit');

Route::get("/history", function(){
    $session = new DebitController();
    $session = $session->orderby();
    dd($session);
    return view('history', ['session' => $session]);
})->name('history');

route::get("/notes", function(){
    return view('notes');
})->name('note');