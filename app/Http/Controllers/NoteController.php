<?php

namespace App\Http\Controllers;

use App\Models\NoteModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NoteController extends Controller
{
    

    public function store(Request $request)
    {
        //dd($request->info);
        if($request->info_classic == "autre")
        {
            $data = [
                'title' => $request->name,
                'content' => $request->info,
                'puits_id' => $request->puits_id
            ];
            $note = new NoteModel();
            $note->storeNote($data['title'], $data['content'], $data['puits_id']);
        }
        
        if($request->info_classic != "autre")
        {
            $data = [
                'title' => $request->name,
                'content' => $request->info_classic,
                'puits_id' => $request->puits_id
            ];
            $note = new NoteModel();
            $note->storeNote($data['title'], $data['content'], $data['puits_id']);
        }
        
        return redirect()->route('home');
    }

    public function show($id)
    {
        $note = new NoteModel();
        $note = $note->getNoteById($id);

        return view('note', ['note' => $note]);
    }

    public function index()
    {
       $note = DB::table('notes')->orderBy("title", "asc")->get();
       return $note;
    }

    public function recherche($data){
        $puits = DB::table('notes')->where('title', 'like', '%'.$data.'%')->get();
        return $puits;
    }
}
