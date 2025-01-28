<?php

namespace App\Http\Controllers;

use App\Models\puits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class puitsController extends Controller
{
    

    public function store($data){
        //dd($data);
        foreach($data as $d){
            if(puits::where('Name', $d[0])->exists()){
                continue;
            }
            $puits = new puits();
            $puits->Name = $d[0];
            $puits->save();
        }
    }

    public function show(){
        $puits = DB::table('puits')->orderBy('Name', 'asc')->get();
        return $puits;
    }

    public function show_id($id){
        $puits = DB::table('puits')->where('id', $id)->get();
        return $puits;
    }

    public function update($id, $data){
        $puits = puits::find($id);
        $puits->type = $data['type'];
        $puits->dimension = $data['dimension'];
        $puits->save();
    }
}


