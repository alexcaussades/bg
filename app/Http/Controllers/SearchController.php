<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $puits = (new puitsController())->recherche($request->search);
        $notes = (new NoteController())->recherche($request->search);

        return view('sr', [
            'puits' => $puits,
            'note' => $notes,
        ]);
    }
}
