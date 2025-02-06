<?php

namespace App\Http\Controllers;

use App\Models\routeModel;
use Illuminate\Http\Request;

class regalgeController extends Controller
{
    public function store($data){
        $route = new routeModel();
        $route->store($data);
    }

    public function get_name($id){
        $route = new routeModel();
        $route = routeModel::find($id);
        return $route;
    }

    public function show(){
        $route = new routeModel();
        $route = $route->get_name();
        return $route;
    }

    public function get_puit_name($name){
        $puit = new puitsController();
        $puit = $puit->show_name($name);
        return $puit;
    }

    public function get_puits_by_name_route($name){
        $puit = new routeModel();
        $puit = $puit->get_puits_by_name_route($name);
        return $puit;
    }
}
