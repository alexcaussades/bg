<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class crj extends Model 
{
    use HasFactory;

    protected $table = 'crj';
    protected $fillable = [
        'torch',
        'temperature',
        'QB',
        'VB',
        'mode',
        'slug',
    ];

    public $timestamps = true;


    public function LastId()
    {
       return crj::orderBy('id', 'desc')->first();
    }

    public function store($data)
    {
        $crj = new crj();
        $crj->torch = $data['torch'];
        $crj->temperature = $data['temperature'];
        $crj->QB = $data['QB'];
        $crj->VB = $data['VB'];
        $crj->mode = $data['mode'];
        $crj->slug = $data['slug'];
        $crj->save();
    }

}
