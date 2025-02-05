<?php

use App\Models\Debit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DebitController;
use App\Http\Controllers\puitsController;
use App\Http\Controllers\DataPuitsController;
use App\Http\Controllers\calculeDebitController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\regalgeController;

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

Route::get("sr", function(Request $request){
    $puits = new puitsController();
    $puits = $puits->recherche($request->search);
    $note = new NoteController();
    $note = $note->recherche($request->search);
    return view('sr', ['puits' => $puits, 'note' => $note]);
})->name('sr');

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

Route::prefix("reglage")->group(function(){

    Route::get('/', function(){
        $route = new regalgeController();
        $sr_route = $route->show();
        return view('reglage.index', ['route' => $sr_route]);
    })->name('reglage.index');

    Route::get('/formule', function(Request $request){
        $id = $request->id;
        $route = new regalgeController();
        $sr_puit = $route->get_name($id);
        $name = $route->get_puit_name($sr_puit->Name);
        if(!$name[0]->type || !$name[0]->dimension || !$name[0]->lignes || !$name[0]->familles){
            return redirect()->route('puits.edit', ['id' => $name[0]->id]);
        }
        return view('reglage.formule', ['puit' => $name, 'id' => $id]);
    })->name('reglage.formule');

   Route::post('/formule', function(Request $request){
        $request->validate([
            'taux' => 'required',
        ]);
        $puit = $request->name;
        $type = $request->type;
        $dimension = $request->dimension;

        $route = new regalgeController();
        $sr_puit = $route->get_name($request->id);
        $name = $route->get_puit_name($sr_puit->Name);

        $route = new regalgeController();
        $sr_puit = $route->show();
        $calule = $request->ch4 * $request->ms / $request->taux;
        $calule = round($calule, 2);

        $debit = new calculeDebitController($request->type, $request->dimension, $request->ms);
        $calculeDebit = $debit->calculeDebit();
        $calculeDebit = round($calculeDebit, 2);

        $debit = new calculeDebitController($request->type, $request->dimension, $calule);
        $newDebit = $debit->calculeDebit();
        $newDebit = round($newDebit, 2);

        $request->session()->put('taux', $request->taux);
        //dd($calculeDebit, $newDebit, $request->ms, $request->ch4, $request->taux, $calule);
        return view('reglage.formule', ['ancien'=> $request->ms, 'result' => $calule, 'puit' => $name, 'type' => $type, 'dimension' => $dimension, 'id' => $request->id, 'old_debit' => $calculeDebit, 'newDebit' => $newDebit]);
    })->name('reglage');

    
});

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
        $data_puit = new puitsController();
        $data_puit = $data_puit->show_name($id);
        if($data->isEmpty()){
            return redirect()->route('history.puit');
        }
        $info = new DataPuitsController();
        $info = $info->famille($data);
        $puit = new puitsController();
        $puit = $puit->moyene($id);
        return view('history.by-puit-id', ['data' => $data, 'moyene' => $puit, 'info' => $info, 'puit' => $data_puit]);
    })->name('history.puit.id');
});

route::prefix('note')->group(function(){
    route::get('/create/{id}', function(Request $request){
        $id = $request->id;
        $puit = new puitsController();
        $puit = $puit->show_id($id);
        return view('note.note_create', ['id' => $id, 'puit' => $puit]);       
    })->name('note.create.id');

    route::post('/create/{id}', function(Request $request){
        $note = new NoteController();
        $note->store($request);
    })->name('note.create');
    
    route::get("/", function(){
        $session = new NoteController();
        $puits = $session->index();
        return view("note.note", ['notes' => $puits]);
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

    Route::get('/borehole', function(Request $request){
        return view('data.borehole');
    })->name('import.Borehole');

    Route::post('/borehole', function(Request $request){
        $request->validate([
            'fichier' => 'required|mimes:xml',
        ]);
        $data = new DataPuitsController();
        $data = $data->borehole($request);
        return redirect()->back()->with('success', 'Data imported successfully.');
    })->name('import.Borehole.import');

    Route::get("/route", function(){
        return view('data.route');
    })->name('import.route');

    Route::post('/route', function(Request $request){
        $request->validate([
            'fichier' => 'required|mimes:xml',
        ]);
        $data = new DataPuitsController();
        $data = $data->route($request);
        return redirect()->back()->with('success', 'Data imported successfully.');
    })->name('import.route.import');
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
        //dd($puit_retard);
        return view("puits.retard_puits", ['retard' => $puit_retard]);
    })->name("puits.retard");

    route::get("/edit/{id}", function(Request $request){
        $id = $request->id;
        $puit = new puitsController();
        $puit = $puit->show_id($id);
        //dd($puit);
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

    route::get("desactive/{id}",function(Request $request ){
        $id = $request->id;
        $puit = new puitsController();
        $puit->desactive($id);
        return redirect()->route('puits.show');
    })->name("puits.desactive");
});

Route::get('/test2', function(){
    
        return view('test');
   
})->name('debit.show');