<?php

use App\Models\Debit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\calculeDebitController;
use App\Http\Controllers\DebitController;
use App\Http\Controllers\puitsController;

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
    return view('history', ['session' => $session]);
})->name('history');


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


Route::prefix("puits")->group(function(){
    Route::get('/show', function(){
        $puits = new puitsController();
        $puit = $puits->show();
        return view("puits.puits_show", ['puits' => $puit]);
    })->name('puits.show');

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
            'dimension' => $request->dimension
        ];
        $puit = new puitsController();
        $puit->update($id, $data);
        return redirect()->route('puits.show');
    })->name('puits.update');
});

Route::get('/test', function(){
    $xml = simplexml_load_file(storage_path('app/public/Boreholes.xml'));
    // ex de parcourir un fichier xml avec simplexml sur   <Borehole ID="ALVR0115">
    $alv = [];
    foreach ($xml->Group as $group) {        
        // Parcourir chaque borehole dans ce groupe
        foreach ($group->Borehole as $borehole) {
            //echo $borehole['ID'] . "\n";
            $boreholeData = [
                (string) $borehole['ID']
            ];
            $alv[] = $boreholeData;
        }
        $puits = new puitsController();
        $puits->store($alv);
    }
   
})->name('debit.show');

Route::get('/test2', function(){
    
        $puits = new puitsController();
        $puit = $puits->show();
        return $puit;
   
})->name('debit.show');