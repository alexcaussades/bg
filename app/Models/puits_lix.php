<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class puits_lix extends Model
{
    use HasFactory;

    protected $table = 'kizeo_puit_lix';

    protected $fillable = [
        'name',
        'auteur',
        'sonde',
        'date',
        'hauteur',
        'difference',
        'mensuel'
    ];

    public function StorePuitsLix($item)
    {
        
        $this->name = $item['name'];
        $this->auteur = $item['Created_by'];
        $this->sonde = $item['sonde'];
        $this->date = $item['Date_de_mesure'];
        $this->hauteur = $item['hauteur'];
        $this->difference =  null;
        $this->mensuel = $item['mensuel'] ?? null;
        $this->save();
    }

    public function get_all_lix(){
        $this->all()->orderBy("id", 'desc')->get();
    }

    public function get_name_lix($name){
        $hauteur_lix = DB::table("kizeo_puit_lix")->where("name", $name)->orderby("id", "desc")->get();
        return $hauteur_lix;
    }

    public function get_mensuel_actual(){
        $date = date("m");
        $lix_mensuel = DB::table("kizeo_puit_lix")->where("mensuel", 1)->where('date', 'like', '%' . $date . '%')->orderby("id", "desc")->get();
        return $lix_mensuel; 
    }

    public function get_mensuel_moins(){
        $date = date("m") - 1;
        $lix_mensuel = DB::table("kizeo_puit_lix")->where("mensuel", 1)->where('date', 'like', '%' . $date . '%')->orderby("id", "desc")->get();
        return $lix_mensuel; 
    }

    public function get_all_lix_unique(){
        $lix_unique = DB::table("kizeo_puit_lix")->distinct()->get(['name']);
        $lix_unique = $lix_unique->map(function($item){
            return $item->name;
        });
        return $lix_unique; 
    }
}
