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
        $puits = DB::table('puits')->orderBy('Name', 'asc')->where('active', '1')->get();
        return $puits;
    }

    public function show_name($name){
        $puits = DB::table('puits')->where('Name', $name)->get();
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
        $puits->familles = $data['familles'];
        $puits->lignes = $data['ligne'];
        $puits->save();
    }

    public function recherche($data){
        $puits = DB::table('puits')->where('Name', 'like', '%'.$data.'%')->get();
        return $puits;
    }

    // rechercher les puits qui ont des données de plus d'un mois qui sont pas encore dans la table puits
    public function recherche_puits(){
        $date = Carbon::now()->subDays(30)->format('d/m/Y H:i:s');
        $datapuits = DB::table('data_puits')->select('puits_id', 'date')->orderBy('date', 'DESC')->get();
        $puits = DB::table('puits')->select("*")->whereNotIn('Name', $datapuits->pluck('puits_id'))->where("active", 1)->get();
        return $puits;
    }

    public function moyene($id){
        // limite de 10 derniers données pour calculer la moyenne dans la table data_puits
        $limit = DB::table('data_puits')->where('puits_id', $id)->count();
        if(10 < $limit){
            $limit = $limit - 10;
            $data = DB::table('data_puits')->where('puits_id', $id)->skip($limit)->take(10)->get();
            $ch4 = 0;
            $co2 = 0;
            $o2 = 0;
            $h2s = 0;
            $depression = 0;
            $m3 = 0;

            foreach($data as $d){
                $ch4 += (float)$d->ch4;
                $co2 += (float)$d->co2;
                $o2 += (float)$d->o2;
                $h2s += (float)$d->h2s;
                $depression += (float)$d->dépression;
                $m3 += (float)($d->m3h);
            }
            $ch4 = $ch4 / 10;
            $co2 = $co2 / 10;
            $o2 = $o2 / 10;
            $h2s = $h2s / 10;
            $depression = $depression / 10;
            $m3 = $m3 / 10;
            $moyene = [
                'ch4' => round($ch4, 2),
                'co2' => round($co2, 2),
                'o2' => round($o2, 2),
                'h2s' => round($h2s, 2),
                'depression' => round($depression, 2),
                'm3' => round($m3, 2)
            ];
        }else{
            $data = DB::table('data_puits')->where('puits_id', $id)->get();
            $ch4 = 0;
            $co2 = 0;
            $o2 = 0;
            $h2s = 0;
            $depression = 0;
            $m3 = 0;
            foreach($data as $d){
                $ch4 += (float)$d->ch4;
                $co2 += (float)$d->co2;
                $o2 += (float)$d->o2;
                $h2s += (float)$d->h2s;
                $depression += (float)$d->dépression;
                $m3 += (float)($d->m3h);
            }
            $ch4 = $ch4 / 10;
            $co2 = $co2 / 10;
            $o2 = $o2 / 10;
            $h2s = $h2s / 10;
            $depression = $depression / 10;
            $m3 = $m3 / 10;
            $moyene = [
                'ch4' => round($ch4, 2),
                'co2' => round($co2, 2),
                'o2' => round($o2, 2),
                'h2s' => round($h2s, 2),
                'depression' => round($depression, 2),
                'm3' => round($m3, 2)
            ];
        }
            return $moyene;
    }

    public function desactive($id){
        $puits = puits::find($id);
        $puits->active = 0;
        $puits->save();
    }

    public function verrify_list_puits_or_reglage_list(){
        $puits = DB::table('puits')->select('Name')->get();
        $list = [];
        foreach($puits as $p){
            if(DB::table('routes')->where('Name', $p->Name)->exists()){
                continue;
            }else{
                array_push($list, $p->Name);
            }
        }
        return $list;
    }
}


