<?php

use App\Models\Debit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DebitController;
use App\Http\Controllers\puitsController;
use App\Http\Controllers\DataPuitsController;
use App\Http\Controllers\calculeDebitController;

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

route::prefix('history')->group(function(){
    route::get("/", function(){
        $session = new DebitController();
        $session = $session->orderby();
        return view("history.history", ['session' => $session]);
    })->name('history');

    Route::get("/history-puit", function(){
        $session = new puitsController();
        $session = $session->show();
        return view('history.by-puit', ['session' => $session]);
    })->name('history.puit');

    Route::get("/history-puit/{puit}", function(Request $request){
        $id = $request->name;
        $data = new DataPuitsController();
        $data = $data->show_id($id);
        if($data->isEmpty()){
            return redirect()->route('history.puit');
        }
        $info = new DataPuitsController();
        $info = $info->famille($data);
        $puit = new puitsController();
        $puit = $puit->moyene($id);
        return view('history.by-puit-id', ['data' => $data, 'moyene' => $puit, 'info' => $info]);
    })->name('history.puit.id');
});


route::prefix('note')->group(function(){
    route::get('/create/{id}', function(Request $request){
        $id = $request->id;
        $puit = new puitsController();
        $puit = $puit->show_id($id);
        return view('note.note_create', ['id' => $id, 'puit' => $puit]);       
    })->name('note.create.id');
    
    route::get("/", function(){
        $session = new puitsController();
        $puits = $session->show();
        
        return view("note.note", ['puits' => $puits]);
    })->name('note');
    
});

Route::prefix('import_data')->group(function(){
    Route::get('/', function(){
        return view('data.csv');
    })->name('import_data');

    Route::post('/import', function(Request $request){
        $request->validate([
            'fichier' => 'required|mimes:csv,txt',
        ]);
        $data = new DataPuitsController();
        $data = $data->import($request);
        return redirect()->back()->with('success', 'Data imported successfully.');
    })->name('import_data.import');
});

Route::prefix("puits")->group(function(){
    Route::get('/show', function(){
        $puits = new puitsController();
        $puit = $puits->show();;
        $puit_retard = $puits->recherche_puits();
        return view("puits.puits_show", ['puits' => $puit, 'retard' => $puit_retard]);
    })->name('puits.show');

    Route::get("/retard", function(){
        $puits = new puitsController();
        $puit_retard = $puits->recherche_puits();
        return view("puits.retard_puits", ['retard' => $puit_retard]);
    })->name("puits.retard");

    route::get("/edit/{id}", function(Request $request){
        $id = $request->id;
        $puit = new puitsController();
        $puit = $puit->show_id($id);
        return view('puits.puits_edit', ['id' => $id, 'puit' => $puit]);
    })->name('puits.edit');

    route::post("/update/{id}", function(Request $request){
        $id = $request->id;
        $data = [
            'type' => $request->type,
            'dimension' => $request->dimension,
            'familles' => $request->familles,
            'ligne' => $request->ligne
        ];
        $puit = new puitsController();
        $puit->update($id, $data);
        return redirect()->route('puits.show');
    })->name('puits.update');
});

Route::get('/test', function(){
    
   
})->name('debit.show');

Route::get('/test2', function(){
    
        return view('test');
   
})->name('debit.show');