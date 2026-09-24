<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotePageController extends Controller
{
    public function index()
    {
        return view('note.note', [
            'notes' => (new NoteController())->index(),
        ]);
    }

    public function create($id)
    {
        return view('note.note_create', [
            'id' => $id,
            'puit' => (new puitsController())->show_id($id),
        ]);
    }

    public function store(Request $request)
    {
        (new NoteController())->store($request);
        return redirect()->route('note')->with('success', 'Data imported successfully.');
    }

    public function createReglage($id, $id2)
    {
        return $this->create($id);
    }

    public function storeReglage(Request $request, $id, $id2)
    {
        (new NoteController())->store($request);
        return redirect()->route('reglage.formule', ['id' => ((int) $id2) + 1]);
    }

    public function archive($id)
    {
        (new NoteController())->archive($id);
        return redirect()->route('note');
    }

    public function preconisation($id)
    {
        (new NoteController())->preconisation($id);
        return redirect()->route('note');
    }
}
