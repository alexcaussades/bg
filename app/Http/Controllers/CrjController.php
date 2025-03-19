<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\crj;
use Illuminate\Http\Request;

class CrjController extends Controller
{
    public function index()
    {
        $crjs = crj::all();
        return view('crj.index', compact('crjs'));
    }

    public function store($data)
    {
        $crj = new crj();
        $crj->torch = $data['torch'];
        $crj->temperature = $data['temperature'];
        $crj->QB = $data['QB'];
        $crj->VB = $data['VB'];
        $crj->slug = Carbon::parse($data['date'])->format('d-m-Y');
        $crj->save();
    }
    //{        
    //     if($request->mode == "valo"){           
    //         $crj = new crj;
    //         $crj->torch = $request->torch;
    //         $crj->temperature = $request->temperature;
    //         $crj->QB = $request->QB;
    //         $crj->VB = $request->VB;
    //         $crj->mode = $request->mode;
    //         $crj->last_id = null;
    //         $crj->slug = Carbon::parse($request->date)->format('d-m-Y');
    //         $crj->save();
            
    //     }
        
    //     $crj = new crj;
    //     $crj->torch = $request->torch;
    //     $crj->temperature = $request->temperature;
    //     $crj->QB = $request->QB;
    //     $crj->VB = $request->VB;
    //     $crj->mode = $request->mode;
    //     $crj->last_id = null;
    //     $crj->slug = Carbon::parse($request->date)->format('d-m-Y');
    //     $crj->save();
        
    // }


}
