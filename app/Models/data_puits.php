<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class data_puits extends Model
{
    use HasFactory;

    protected $table = 'data_puits';

    protected $fillable = [
        'puits_id',
        'date',
        'ch4',
        'co2',
        'o2',
        'balance',
        'co',
        'h2',
        'h2s',
        'dépression',
        'temperature',
        'm3h',
        'av_m3h',
        'ratio',
        'av_dep',
    ];
}
