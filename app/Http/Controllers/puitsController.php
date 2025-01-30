<?php

namespace App\Http\Controllers;

use App\Models\puits;
use Carbon\Carbon;
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

    public function recherche($data){
        $puits = DB::table('puits')->where('Name', 'like', '%'.$data.'%')->get();
        return $puits;
    }

    // rechercher les puits qui ont des données de plus d'un mois qui sont pas encore dans la table puits
    public function recherche_puits(){
        $date = Carbon::now()->subDays(30)->format('d/m/Y H:i:s');
        $datapuits = DB::table('data_puits')->select('puits_id', 'date')->orderBy('Date', 'DESC')->groupBy('puits_id')->having('date', '<', $date)->get();
        $puits = DB::table('puits')->select("Name")->whereNotIn('Name', $datapuits->pluck('puits_id'))->get();
        return $puits;
    }
}


