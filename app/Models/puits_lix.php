<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
