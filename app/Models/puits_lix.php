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
        'date',
        'hauteur',
        'difference',
        'mensuel'
    ];
}
