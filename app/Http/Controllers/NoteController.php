<?php

namespace App\Http\Controllers;

use App\Models\NoteModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NoteController extends Controller
{
    

    public function store(Request $request)
    {
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
       $note = DB::table('notes')->where("status", "active")->orderBy("created_at", "desc")->get();
       return $note;
    }

    public function recherche($data){
        $puits = DB::table('notes')->where('title', 'like', '%'.$data.'%')->get();
        return $puits;
    }

    public function update($id, $data){
        $note = NoteModel::find($id);
        $note->title = $data['title'];
        $note->content = $data['content'];
        $note->save();
    }

    public function destroy($id){
        $note = NoteModel::find($id);
        $note->delete();
    }

    public function archive($id){
        $note = DB::table('notes')->where('id', $id)->update(['status' => 'archived']);
        return $note;
    }

    public function unarchive($id){
        $note = DB::table('notes')->where('id', $id)->update(['status' => 'active']);
        return $note;
    }

    public function show_archived(){
        $note = DB::table('notes')->where('status', 'archived')->get();
        return $note;
    }
}
