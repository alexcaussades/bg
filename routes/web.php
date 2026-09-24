<?php

use App\Http\Controllers\AuthPageController;
use App\Http\Controllers\DatabaseBackupController;
use App\Http\Controllers\DebitPageController;
use App\Http\Controllers\HistoryPageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImportDataPageController;
use App\Http\Controllers\NotePageController;
use App\Http\Controllers\PuitsPageController;
use App\Http\Controllers\ReglagePageController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\TtcrPageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| RegBio Web Routes
|--------------------------------------------------------------------------
| Les routes décrivent uniquement les URL et délèguent le traitement
| aux controllers. La logique métier ne doit pas être placée ici.
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

// -------------------------------------------------------------------------
// Authentification
// -------------------------------------------------------------------------
Route::prefix('auth')->group(function () {
    Route::get('/login', [AuthPageController::class, 'login'])->name('login');
    Route::get('/register', [AuthPageController::class, 'register'])->name('register');
    Route::get('/cgu', [AuthPageController::class, 'cgu'])->name('cgu');
    Route::post('/register', [AuthPageController::class, 'registerStore'])->name('register.store');
    Route::post('/login', [AuthPageController::class, 'loginStore'])->name('login.store');
    Route::get('/logout', [AuthPageController::class, 'logout'])->name('logout');
    Route::get('/my-account', [AuthPageController::class, 'account'])->name('my-account')->middleware('auth');
});

Route::middleware('auth')->group(function () {

    // ---------------------------------------------------------------------
    // Recherche
    // ---------------------------------------------------------------------
    Route::get('/sr', [SearchController::class, 'index'])->name('sr');

    // ---------------------------------------------------------------------
    // Calcul de débit
    // ---------------------------------------------------------------------
    Route::get('/debit', [DebitPageController::class, 'index'])->name('debit');

    // ---------------------------------------------------------------------
    // Réglage
    // ---------------------------------------------------------------------
    Route::prefix('reglage')->group(function () {
        Route::get('/', [ReglagePageController::class, 'index'])->name('reglage.index');
        Route::get('/formule', [ReglagePageController::class, 'formule'])->name('reglage.formule');
        Route::post('/formule', [ReglagePageController::class, 'calculate'])->name('reglage');
        Route::get('/edit/{id}', [ReglagePageController::class, 'edit'])->name('reglage.edit');
        Route::post('/edit/{id}', [ReglagePageController::class, 'update'])->name('reglage.update');
        Route::get('/ajuster', [ReglagePageController::class, 'ajuster'])->name('reglage.ajuster');
        Route::post('/ajuster', [ReglagePageController::class, 'calculateAjustement'])->name('reglage.ajuster.view');
    });

    // ---------------------------------------------------------------------
    // Historique
    // ---------------------------------------------------------------------
    Route::prefix('history')->group(function () {
        Route::get('/', [HistoryPageController::class, 'index'])->name('history');
        Route::get('/history-puit', [HistoryPageController::class, 'puits'])->name('history.puit');
        Route::get('/history-puit/{puit}', [HistoryPageController::class, 'puitsDetails'])->name('history.puit.id');
    });

    // ---------------------------------------------------------------------
    // Notes
    // ---------------------------------------------------------------------
    Route::prefix('note')->group(function () {
        Route::get('/', [NotePageController::class, 'index'])->name('note');
        Route::get('/create/{id}', [NotePageController::class, 'create'])->name('note.create.id');
        Route::post('/create/{id}', [NotePageController::class, 'store'])->name('note.create');
        Route::get('/reglages/note/create/{id}/{id2}', [NotePageController::class, 'createReglage'])->name('note.reglage.create.id');
        Route::post('/reglages/note/create/{id}/{id2}', [NotePageController::class, 'storeReglage'])->name('note.reglage.create');
        Route::get('/archive/{id}', [NotePageController::class, 'archive'])->name('note.archive');
        Route::get('/preconisation/{id}', [NotePageController::class, 'preconisation'])->name('note.preconisation');
    });

    // ---------------------------------------------------------------------
    // Imports
    // ---------------------------------------------------------------------
    Route::prefix('import_data')->group(function () {
        Route::get('/', [ImportDataPageController::class, 'index'])->name('import_data');
        Route::post('/import', [ImportDataPageController::class, 'import'])->name('import_data.import');
        Route::get('/borehole', [ImportDataPageController::class, 'borehole'])->name('import.Borehole');
        Route::post('/borehole', [ImportDataPageController::class, 'importBorehole'])->name('import.Borehole.import');
        Route::get('/route', [ImportDataPageController::class, 'route'])->name('import.route');
        Route::post('/route', [ImportDataPageController::class, 'importRoute'])->name('import.route.import');
    });

    // ---------------------------------------------------------------------
    // Puits
    // ---------------------------------------------------------------------
    Route::prefix('puits')->group(function () {
        Route::get('/show', [PuitsPageController::class, 'show'])->name('puits.show');
        Route::get('/retard', [PuitsPageController::class, 'retard'])->name('puits.retard');
        Route::get('/edit/{id}', [PuitsPageController::class, 'edit'])->name('puits.edit');
        Route::post('/update/{id}', [PuitsPageController::class, 'update'])->name('puits.update');
        Route::get('/desactive/{id}', [PuitsPageController::class, 'desactive'])->name('puits.desactive');
        Route::get('/mesure-lixivats', [PuitsPageController::class, 'mesureLixivats'])->name('puit.lixivats');
    });

      // ---------------------------------------------------------------------
    // TTCR
    // ---------------------------------------------------------------------
    Route::prefix('ttcr')->group(function () {
        Route::get('/', [TtcrPageController::class, 'index'])->name('ttcr.index');
        Route::get('/create', [TtcrPageController::class, 'create'])->name('ttcr.create');
        Route::post('/create', [TtcrPageController::class, 'store'])->name('ttcr.store');
        Route::get('/install', [TtcrPageController::class, 'install'])->name('ttcr.install');
    });
});

// -------------------------------------------------------------------------
// Sauvegarde de la base
// -------------------------------------------------------------------------

Route::get('/copydata', [DatabaseBackupController::class, 'copy'])->name('database.copy')->middleware('auth');

// -------------------------------------------------------------------------
// Routes de développement
// -------------------------------------------------------------------------
Route::get('/test', [TestController::class, 'test'])->name('test');
