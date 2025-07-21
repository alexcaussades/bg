<?php

use App\Models\consignation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\TtcrController;
use App\Http\Controllers\DebitController;
use App\Http\Controllers\KizeoController;
use App\Http\Controllers\puitsController;
use App\Http\Controllers\regalgeController;
use App\Http\Controllers\DataPuitsController;
use App\Http\Controllers\AnalyseBioController;
use App\Http\Controllers\calculeDebitController;
use App\Http\Controllers\ConsignationController;

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
    $data_puits_count = DB::table('puits')->select('id')->count();
    $data_note_count = DB::table('notes')->select('id')->where("status", "active")->count();
    //$data_consignation_count = DB::table('consignations')->select('id')->count();
    $data_debit_count = DB::table('debit')->select('id')->count();
    $data_data_count = DB::table('data_puits')->select('id')->count();
    $data_reglage_count = null;
    return view('home', ['puits' => $data_puits_count, 'note' => $data_note_count, 'debit' => $data_debit_count, 'data' => $data_data_count, 'reglage' => $data_reglage_count]);
})->name('home');

Route::prefix('auth')->group(function(){
    Route::get('/login', function(Request $request){
        if($request->cookie('authToken')){
            $Auth = new AuthController();
            $Auth->checktoken();
            return redirect()->route('home');
        }
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
        $Auth = new AuthController();
        $Auth->login($request);
        return redirect()->route('home');
    })->name('login.store');

    Route::get('/logout', function(){
        $Auth = new AuthController();
        $Auth->logout();
        return redirect()->route('home');
    })->name('logout');

    Route::get("/my-account", function(){
        $Auth = new AuthController();
        $user = $Auth->my_account();
        return view('auth.my-account', ['user' => $user]);
    })->name('my-account')->middleware('auth');
});

Route::get("sr", function(Request $request){
    $puits = new puitsController();
    $puits = $puits->recherche($request->search);
    $note = new NoteController();
    $note = $note->recherche($request->search);
    return view('sr', ['puits' => $puits, 'note' => $note]);
})->name('sr')->middleware('auth');

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

    Route::get('/', function(Request $request){
        $route = new regalgeController();
        $sr_route = $route->show();
        if($request->cookie('last_id')){
            $id = $request->cookie('last_id');
            $new_id = $id + 1;
            return view('reglage.index', ['route' => $sr_route, 'id' => $new_id]);
        }
        return view('reglage.index', ['route' => $sr_route]);
    })->name('reglage.index')->middleware('auth');

    Route::get('/formule', function(Request $request){
        $id = $request->id;
        $id2 = $request->id + 1;
        $route = new regalgeController();
        $sr_puit = $route->get_name($id);
        $name = $route->get_puit_name($sr_puit->Name);
        $last = DB::table('data_puits')->where('puits_id', $sr_puit->Name)->orderBy('id', 'desc')->get();
        $note_sr = new NoteController();
        $note_sr = $note_sr->puits_id($name[0]->id);
      
        if($last->isEmpty()){
            $last = null;
        }
        
        if(!$name[0]->type || !$name[0]->dimension || !$name[0]->lignes || !$name[0]->familles){
            return redirect()->route('reglage.edit', ['id' => $id]);
        }
        
        return view('reglage.formule', ['puit' => $name, 'id' => $id, 'last' => $last ? $last : null, 'note' => $name[0]->id, 'id2' => $id2, 'note_sr' => $note_sr]);
    })->name('reglage.formule')->middleware('auth');

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
        Cookie::queue(Cookie::make('last_id', $request->id, 200, '/', null, false, false));
        $last = DB::table('data_puits')->where('puits_id', $puit)->latest()->get();
        if($last->isEmpty()){
            $last = null;
        }
        return view('reglage.formule', ['ancien'=> $request->ms, 'result' => $calule, 'puit' => $name, 'type' => $type, 'dimension' => $dimension, 'id' => $request->id, 'old_debit' => $calculeDebit, 'newDebit' => $newDebit, 'note'=> $note, 'last' => $last]);
    })->name('reglage')->middleware('auth');

    Route::get('/edit/{id}', function(Request $request){
        $id = $request->id;
        $route = new regalgeController();
        $sr_puit = $route->get_name($id);
        $name = $route->get_puit_name($sr_puit->Name);
        $route = new regalgeController();
        $sr_route = $route->show();
        return view('reglage.edit_formule', ['puit' => $name, 'id' => $id, 'route' => $sr_route]);
    })->name('reglage.edit')->middleware('auth');

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
    })->name('reglage.update')->middleware('auth');
    
    Route::get("/ajuter", function(Request $request){
            $id = $request->cookie('last_id');
            $route = new regalgeController();
            $sr_puit = $route->get_name($id);
            $name = $route->get_puit_name($sr_puit->Name);
        return view('reglage.ajuster', ['puit' => $name, 'id' => $id]);
    })->name('reglage.ajuter')->middleware('auth');

    Route::post("/ajuter", function(Request $request){
        $request->validate([
            'debit' => 'required',
        ]);
        $route = new regalgeController();
        $sr_puit = $route->get_name($request->id);
        $name = $route->get_puit_name($sr_puit->Name);
        $note = $name[0]->id;
        $route2 = new calculeDebitController($request->type, $request->dimension, 0);
        $calcule = $route2->ajuster_debit($request->debit);
        $calule = round($calcule, 2);
        return view('reglage.ajuster', ['result' => $calule, 'puit' => $name, 'id' => $request->id, 'note' => $note]);
    })->name('reglage.ajuter.view')->middleware('auth');
});

route::prefix('history')->group(function(){
    route::get("/", function(){
        $session = new DebitController();
        $session = $session->orderby();
        return view("history.history", ['session' => $session]);
    })->name('history')->middleware('auth');

    Route::get("/history-puit", function(){
        $session = new puitsController();
        $session = $session->show();
        return view('history.by-puit', ['session' => $session]);
    })->name('history.puit')->middleware('auth');

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
        $note_sr = new NoteController();
        $note_sr = $note_sr->puits_id($data_puit[0]->id);
        return view('history.by-puit-id', ['data' => $data, 'moyene' => $puit, 'info' => $info, 'puit' => $data_puit, 'note' => $note_sr]);
    })->name('history.puit.id')->middleware('auth');
})->middleware('auth');

route::prefix('note')->group(function(){
    route::get('/create/{id}', function(Request $request){
        $id = $request->id;
        $puit = new puitsController();
        $puit = $puit->show_id($id);
        return view('note.note_create', ['id' => $id, 'puit' => $puit]);       
    })->name('note.create.id')->middleware('auth');

    route::post('/create/{id}', function(Request $request){
        $note = new NoteController();
        $note->store($request);        
        return redirect()->route('note')->with('success', 'Data imported successfully.');
    })->name('note.create')->middleware('auth');

    route::get('/reglages/note/create/{id}/{id2}', function(Request $request){
        $id = $request->id;
        $puit = new puitsController();
        $puit = $puit->show_id($id);
        return view('note.note_create', ['id' => $id, 'puit' => $puit]);       
    })->name('note.reglage.create.id')->middleware('auth');

    route::post('/reglages/note/create/{id}/{id2}', function(Request $request){
        $note = new NoteController();   
        $note->store($request);
        $id2 = $request->id2;
        $id2 = $id2 + 1; 
        return redirect()->route('reglage.formule', ['id' => $id2]);
    })->name('note.reglage.create')->middleware('auth');
    
    route::get("/", function(){
        $session = new NoteController();
        $puits = $session->index();
        return view("note.note", ['notes' => $puits]);
    })->name('note')->middleware('auth');

    route::get('/archive/{id}', function(Request $request){
        $id = $request->id;
        $note = new NoteController();
        $note->archive($id);
        return redirect()->route('note');
    })->name('note.archive')->middleware('auth');

    route::get("/preconisation/{id}", function(Request $request){
        $id = $request->id;
        $note = new NoteController();
        $note = $note->preconisation($id);
        $session = new NoteController();
        $puits = $session->index();
        return view("note.note", ['notes' => $puits]);
    })->name('note.preconisation')->middleware('auth');
    
})->middleware('auth');

Route::prefix('import_data')->group(function(){
    Route::get('/', function(){
        return view('data.csv');
    })->name('import_data')->middleware('auth');

    Route::post('/import', function(Request $request){
        $request->validate([
            'fichier' => 'required|mimes:csv,txt',
        ]);
        $data = new DataPuitsController();
        $data = $data->import($request);
        return redirect()->back()->with('success', 'Data imported successfully.');
    })->name('import_data.import')->middleware('auth');

    Route::get('/borehole', function(Request $request){
        return view('data.borehole');
    })->name('import.Borehole')->middleware('auth');

    Route::post('/borehole', function(Request $request){
        $request->validate([
            'fichier' => 'required|mimes:xml',
        ]);
        $data = new DataPuitsController();
        $data = $data->borehole($request);
        return redirect()->back()->with('success', 'Data imported successfully.');
    })->name('import.Borehole.import')->middleware('auth');

    Route::get("/route", function(){
        return view('data.route');
    })->name('import.route')->middleware('auth');

    Route::post('/route', function(Request $request){
        $request->validate([
            'fichier' => 'required|mimes:xml',
        ]);
        $data = new DataPuitsController();
        $data = $data->route($request);
        return redirect()->back()->with('success', 'Data imported successfully.');
    })->name('import.route.import')->middleware('auth');
})->middleware('auth');

Route::prefix("puits")->group(function(){
    Route::get('/show', function(){
        $puits = new puitsController();
        $puit = $puits->show();;
        $puit_retard = $puits->recherche_puits();
        return view("puits.puits_show", ['puits' => $puit, 'retard' => $puit_retard]);
    })->name('puits.show')->middleware('auth');

    Route::get("/retard", function(){
        $puits = new puitsController();
        $puit_retard = $puits->recherche_puits();
        //dd($puit_retard);
        return view("puits.retard_puits", ['retard' => $puit_retard]);
    })->name("puits.retard")->middleware('auth');

    route::get("/edit/{id}", function(Request $request){
        $id = $request->id;
        $puit = new puitsController();
        $puit = $puit->show_id($id);
        //dd($puit);
        return view('puits.puits_edit', ['id' => $id, 'puit' => $puit]);
    })->name('puits.edit')->middleware('auth');

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
    })->name('puits.update')->middleware('auth');

    route::get("desactive/{id}",function(Request $request ){
        $id = $request->id;
        $puit = new puitsController();
        $puit->desactive($id);
        return redirect()->route('puits.show');
    })->name("puits.desactive")->middleware('auth');

    Route::get("mesure-lixivats", function(){
        $puits = new puitsController();
        $puit = $puits->show();;
        $puit_retard = $puits->recherche_puits();
    })->name("puit.lixivats")->middleware('auth');
})->middleware('auth');

// Route::prefix("consignation")->group(function(){

//     Route::get("/index", function(){
//     $consignation = new ConsignationController();
//     $consignation = $consignation->show();
//     return view("consignation.index", ["consignation" => $consignation]);
//     })->name("consignation.index")->middleware('auth');

//     Route::post('/index', function(Request $request){
//         $consignation = new ConsignationController();
//         $consignation->create($request);
//         $consignationstart = new ConsignationController();
//         $consignationstart = $consignationstart->show();
//         return view("consignation.show", ["consignation" => $consignationstart]);
//     })->name("consignation.index")->middleware('auth');
    
//     Route::get("/show", function(){
//         $consignation = new ConsignationController();
//         $consignation = $consignation->show();
//         return view("consignation.show", ["consignation" => $consignation]);
//     })->name("consignation.show")->middleware('auth');

//     Route::get('/view/{id}', function(Request $request){
//        $id = $request->id;
//        $consignation = new ConsignationController();
//        $consignation = $consignation->view($id);
//        $img = Storage::url("images/".$consignation->photo);
//        $donwload = Storage::url("images/".$consignation->photo);
//        return view("consignation.view", ["consignation" => $consignation, "img" => $img, "donwload" => $donwload]);
//     })->name('consignation.view')->middleware('auth');
// })->middleware('auth');

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

Route::prefix("analyse")->group(function(){
   route::get("/", function(){
        $ssr = new AnalyseBioController();
        // $low = $ssr->analyseBio_forCH4_low();
        // $mid = $ssr->analyseBio_forCH4_mid();
        $high = $ssr->analyseBio_forCH4_high();
        //dd($low, $mid, $high);
        dd($high);
       return view('analyse.analyse');
   })->name('analyse')->middleware('auth');
});

Route::prefix('/ttcr')->group(function(){
    Route::get('/', function(){
        $ttcr = new TtcrController();
        $ttcr = $ttcr->index();
        return view('ttcr.index', ['ttcr' => $ttcr]);
    })->name('ttcr.index')->middleware('auth');

    Route::get('/create', function(){
        return view('ttcr.create');
    })->name('ttcr.create')->middleware('auth');

    Route::post('/create', function(Request $request){
        $ttcr = new TtcrController();
        $ttcr->store($request);
        return redirect()->route('ttcr.index');
    })->name('ttcr.store')->middleware('auth');

    Route::get('/install', function(){
        $ttcr = new TtcrController();
        $ttcr->install_ttcr();
        return redirect()->route('ttcr.index');
    })->name('ttcr.install')->middleware('auth');

})->middleware('auth');

Route::prefix('kizeo')->group(function(){
    Route::get('/', function(){
        return view('kizeo.index');
    })->name('kizeo.index')->middleware('auth');

    Route::get("enregistrement_des_bassins", function(){
        return view('kizeo.bassin');
    })->name('kizeo.register.bassin')->middleware('auth');

    Route::get("enregistrement_Torch_Vapo", function(){
       return view('kizeo.torch_vapo');
    })->name('kizeo.register.torch_vapo')->middleware('auth');

    Route::get("enregistrement_ttcr", function(){
        return view('kizeo.ttcr');
    })->name('kizeo.register.ttcr')->middleware('auth');

    Route::get("enregistrement_biogaz", function(){
        return view('kizeo.biogaz');
    })->name('kizeo.register.biogaz')->middleware('auth');

    Route::post('/import_kizeo_bassin', function(Request $request){
        $request->validate([
            'fichier' => 'required|mimes:xlsx,csv',
        ]);
        $kizeo = new KizeoController();
        $kizeo->import_kizeo_bassin($request);
        return redirect()->back()->with('success', 'Data imported successfully.');
    })->name('kizeo.import_kizeo_bassin')->middleware('auth');

    Route::post('/import_kizeo_torch_vapo', function(Request $request){
        $request->validate([
            'fichier' => 'required|mimes:xlsx,csv',
        ]);
        $kizeo = new KizeoController();
        $kizeo->import_kizeo_Torch_Vapo($request);
        return redirect()->back()->with('success', 'Data imported successfully.');
    })->name('kizeo.import_kizeo_torch_vapo')->middleware('auth');

    Route::post('/import_kizeo_ttcr', function(Request $request){
        $request->validate([
            'fichier' => 'required|mimes:xlsx,csv',
        ]);
        $kizeo = new KizeoController();
        $kizeo->import_kizeo_ttcr($request);
        return redirect()->back()->with('success', 'Data imported successfully.');
    })->name('kizeo.import_kizeo_ttcr')->middleware('auth');

    Route::post('/import_kizeo_biogaz', function(Request $request){
        $request->validate([
            'fichier' => 'required|mimes:xlsx,csv',
        ]);
        $kizeo = new KizeoController();
        $kizeo->import_kizeo_biogaz($request);
        return redirect()->back()->with('success', 'Data imported successfully.');
    })->name('kizeo.import_kizeo_biogaz')->middleware('auth');

});