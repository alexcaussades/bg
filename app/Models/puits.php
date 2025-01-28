<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class puits extends Model
{
    use HasFactory;

    protected $table = 'puits';

    protected $fillable = [
        "name",
        "type",
        "dimension"
    ];

    

  
}