<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\DebitController;
use App\Http\Controllers\puitsController;
use App\Http\Controllers\regalgeController;
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

Route::prefix('auth')->group(function(){
    Route::get('/login', function(){
        return view('auth.login');
    })->name('login');

    Route::get('/register', function(){
        return view('auth.register');
    })->name('register');

    Route::get('/cgu', function(){
        return view('cgu');
    })->name('cgu');

    Route::post('/register', function(Request $request){
        $Auth = new AuthController();
        $Auth->register($request);
        return redirect()->route('login');
    })->name('register.store');

    Route::post('/login', function(Request $request){
        dd($request->all());
        return redirect()->route('home');
    })->name('login.store');
});

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
            return redirect()->route('reglage.edit', ['id' => $id]);
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
        $note = $name[0]->id;

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
        return view('reglage.formule', ['ancien'=> $request->ms, 'result' => $calule, 'puit' => $name, 'type' => $type, 'dimension' => $dimension, 'id' => $request->id, 'old_debit' => $calculeDebit, 'newDebit' => $newDebit, 'note'=> $note]);
    })->name('reglage');

    Route::get('/edit/{id}', function(Request $request){
        $id = $request->id;
        $route = new regalgeController();
        $sr_puit = $route->get_name($id);
        $name = $route->get_puit_name($sr_puit->Name);
        $route = new regalgeController();
        $sr_route = $route->show();
        return view('reglage.edit_formule', ['puit' => $name, 'id' => $id, 'route' => $sr_route]);
    })->name('reglage.edit');

    Route::post('/edit/{id}', function(Request $request){
        $request->validate([
            'type' => 'required',
            'dimension' => 'required',
            'familles' => 'required',
            'ligne' => 'required',
        ]);
        $data = [
            'type' => $request->type,
            'dimension' => $request->dimension,
            'familles' => $request->familles,
            'ligne' => $request->ligne
        ];
        $puit = new puitsController();
        $puits_id = $puit->show_name($request->name);
        $puit->update($puits_id[0]->id, $data);
        $reglage = new regalgeController();
        $get_name = $reglage->get_puits_by_name_route($request->name);
        return redirect()->route('reglage.formule', ['id' => $get_name[0]->id]);
    })->name('reglage.update');
    
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
        redirect()->route('note');
    })->name('note.create');

    route::get('/reglages/note/create/{id}/{id2}', function(Request $request){
        $id = $request->id;
        $puit = new puitsController();
        $puit = $puit->show_id($id);
        return view('note.note_create', ['id' => $id, 'puit' => $puit]);       
    })->name('note.reglage.create.id');

    route::post('/reglages/note/create/{id}/{id2}', function(Request $request){
        $note = new NoteController();   
        $note->store($request);
        $id2 = $request->id2;
        $id2 = $id2 + 1; 
        return redirect()->route('reglage.formule', ['id' => $id2]);
    })->name('note.reglage.create');
    
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

Route::get("/copydata", function(){
    $source = database_path('database.sqlite');
    $date = date('d-m-Y-H-i');
    if(!is_dir(database_path('backup'))){
        mkdir(database_path('backup'), 0777, true);
    }
    $destination = database_path('backup/database_'.$date.'.sqlite');

    if (!copy($source, $destination)) {
        return response()->json(['message' => 'Failed to copy database'], 500);
    }

    return response()->json(['message' => 'Database copied successfully'], 200);
})->name('database.copy');

Route::get('/database', function(){
    // faire des statiques sur la base de donnée data_puits
    $data = DB::table('data_puits')->get();
    $data = $data->toArray();
    $data = json_decode(json_encode($data), true);
    $data = collect($data);
    $explode = $data->map(function($item){
        $item['date'] = explode(' ', $item['date'])[0];
        return $item;
    });
    $data = $data->groupBy($explode);
    $data = $data->toArray();
    $data = json_decode(json_encode($data), true);
    $data = collect($data);
    return $data;
})->name('database');