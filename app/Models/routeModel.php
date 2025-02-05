<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class routeModel extends Model
{
    use HasFactory;

    protected $table = 'routes';

    protected $fillable = [
        'Name'
    ];

    public function store($data){
        //dd($data);
        for ($i=0; $i < count($data); $i++) { 
            if(routeModel::where('Name', $data[$i])->exists()){
                continue;
            }
            $route = new routeModel();
            $route->Name = $data[$i];
            $route->save();
        }
    }

    public function get_name(){
        $route = DB::table('routes')->select("id", 'Name')->get();
        return $route;
    }
    
}
