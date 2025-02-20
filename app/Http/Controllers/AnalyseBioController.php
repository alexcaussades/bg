<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use function Laravel\Prompts\select;

class AnalyseBioController extends Controller
{
    // Analyse des données des mesures du biogaz avant et après traitement CH4, CO2, H2S, O2, Débit (augmentation, réduction), Température, Pression, dépressions (augmentation, réduction).

    public function analyseBio_fordate()
    {
        $data = "02/2025";
        $r = DB::table("data_puits")->where('date', 'like', '%'.$data.'%')->get();
        return $r;
    }
}
