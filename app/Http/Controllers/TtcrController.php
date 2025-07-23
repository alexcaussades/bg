<?php

namespace App\Http\Controllers;

use App\Models\ttcr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TtcrController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ttcr = DB::table('ttcrs')->orderBy('id', 'desc')->get();
        return $ttcr;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $hauteur = $this->hauteurdeau($request->hauteur);
        $old_ttcr = ttcr::latest()->first();
        $ttcr = new ttcr();
        $ttcr->compteur = $request->compteur;
        $ttcr->evolution = $request->compteur - $old_ttcr->compteur;
        $ttcr->hauteur = $request->hauteur;
        $ttcr->volume = $hauteur;
        $ttcr->save();
        return $ttcr;
    }

    public function Store_from_Kizeo_import_file($data)
    {
        $ttcr = new ttcr();
        $ttcr->compteur = $data['compteur'];
        $ttcr->evolution = $data['compteur'] - ttcr::latest()->first()->compteur;
        $ttcr->hauteur = $data['hauteur'];
        $ttcr->volume = $this->hauteurdeau($data['hauteur']);
        $ttcr->save();
    }

    public function install_ttcr()
    {
        if (ttcr::all()->count() == 0) {
            $ttcr = new ttcr();
            $ttcr->compteur = 7499;
            $ttcr->evolution = 0;
            $ttcr->hauteur = 141;
            $ttcr->volume = 1692;
            $ttcr->save();
            return view('ttct.index');
        }else{
            return view('home');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ttcr $ttcr)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ttcr $ttcr)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ttcr $ttcr)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ttcr $ttcr)
    {
        //
    }

    Public function hauteurdeau($info)
    {
       $hauteur = [
            "167" => 2004,
            "166" => 1992,
            "165" => 1980,
            "164" => 1968,
            "163" => 1956,
            "162" => 1944,
            "161" => 1932,
            "160" => 1920,
            "159" => 1908,
            "158" => 1896,
            "157" => 1884,
            "156" => 1872,
            "155" => 1860,
            "154" => 1848,
            "153" => 1836,
            "152" => 1824,
            "151" => 1812,
            "150" => 1800,
            "149" => 1788,
            "148" => 1776,
            "147" => 1764,
            "146" => 1752,
            "145" => 1740,
            "144" => 1728,
            "143" => 1716,
            "142" => 1704,
            "141" => 1692,
            "140" => 1680,
            "139" => 1668,
            "138" => 1656,
            "137" => 1644,
            "136" => 1632,
            "135" => 1620,
            "134" => 1608,
            "133" => 1596,
            "132" => 1584,
            "131" => 1572,
            "130" => 1560,
            "129" => 1548,
            "128" => 1536,
            "127" => 1524,
            "126" => 1512,
            "125" => 1500,
            "124" => 1488,
            "123" => 1476,
            "122" => 1464,
            "121" => 1452,
            "120" => 1440,
            "119" => 1428,
            "118" => 1416,
            "117" => 1404,
            "116" => 1392,
            "115" => 1380,
            "114" => 1368,
            "113" => 1356,
            "112" => 1344,
            "111" => 1332,
            "110" => 1320,
            "109" => 1308,
            "108" => 1296,
            "107" => 1284,
            "106" => 1272,
            "105" => 1260,
            "104" => 1248,
            "103" => 1236,
            "102" => 1224,
            "101" => 1212,
            "100" => 1200,
            "99" => 1188,
            "98" => 1176,
            "97" => 1164,
            "96" => 1152,
            "95" => 1140,
            "94" => 1128,
            "93" => 1116,
            "92" => 1104,
            "91" => 1092,
            "90" => 1080,
            "89" => 1068,
            "88" => 1056,
            "87" => 1044,
            "86" => 1032,
            "85" => 1020,
            "84" => 1008,
            "83" => 996,
            "82" => 984,
            "81" => 972,
            "80" => 960,
            "79" => 948,
            "78" => 936,
            "77" => 924,
            "76" => 912,
            "75" => 900,
            "74" => 888,
            "73" => 876,
            "72" => 864,
            "71" => 852,
            "70" => 840,
            "69" => 828,
            "68" => 816,
            "67" => 804,
            "66" => 792,
            "65" => 780,
            "64" => 768,
            "63" => 756,
            "62" => 744,
            "61" => 732,
            "60" => 720,
            "59" => 708,
            "58" => 696,
            "57" => 684,
            "56" => 672,
            "55" => 660,
            "54" => 648,
            "53" => 636,
            "52" => 624,
            "51" => 612,
            "50" => 600,
            "49" => 588,
            "48" => 576,
            "47" => 564,
            "46" => 552,
            "45" => 540,
            "44" => 528,
            "43" => 516,
            "42" => 504,
            "41" => 492,
            "40" => 480,
            "39" => 468,
            "38" => 456,
            "37" => 444,
            "36" => 432,
            "35" => 420,
            "34" => 408,
            "33" => 396,
            "32" => 384,
            "31" => 372,
            "30" => 360,
            "29" => 348,
            "28" => 336,
            "27" => 324,
            "26" => 312,
            "25" => 300,
            "24" => 288,
            "23" => 276,
            "22" => 264,
            "21" => 252,
            "20" => 240,
            "19" => 228,
            "18" => 216,
            "17" => 204,
            "16" => 192,
            "15" => 180,
            "14" => 168,
            "13" => 156,
            "12" => 144,
            "11" => 132,
            "10" => 120,
            "9" => 108,
            "8" => 96,
            "7" => 84,
            "6" => 72,
            "5" => 60,
            "4" => 48,
            "3" => 36,
            "2" => 24,
            "1" => 12
        ];

        $hauteur1 = $hauteur[$info];

        return $hauteur1;
    }

}
