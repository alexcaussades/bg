<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class consignation extends Model
{
    use HasFactory;

    protected $table = 'consignations';

    protected $fillable = [
        'id',
        'type',
        'Équipements',
        'info',
        'photo'
    ];

    public function get_all(){
        $note = DB::table('consignation')->orderBy("type", "asc")->get();
        return $note;
    }

  

}
