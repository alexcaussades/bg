<?php

namespace App\Http\Controllers;

use App\Models\Debit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class calculeDebitController extends Controller
{

public $type;
public $dimension;
public $ms;

public function __construct($type, $dimension, $ms)
    {
    $this->type = $type;
    $this->dimension = $dimension;
    $this->ms = $ms;

    }

    public function calculeDebit()
    {
        $sr_debit = [
            "type" => [
                "SDR11" => [
                    "32" => 1.90,
                    "40" => 3.00,
                    "63" => 7.50,
                    "90" => 20.72,
                    "110" => 30.94,
                    "160" => 65.32,
                    "200" => 102.96,
                    "250" => 159.62,
                    "315" => 253.80,
                ],
                "SDR17" => [
                    "32" =>2.20,
                    "40" => 3.50,
                    "63" => 8.80,
                    "90" => 18,
                    "110" => 26.84,
                    "160" => 56.85,
                    "200" => 88.78,
                    "250" => 138.85,
                    "315" => 220.40,
                ],
                "SDR33" => [
                    "63" => 9.80,
                    "90" => 20.14,
                    "110" => 31.11,
                    "160" => 63.79,
                    "200" => 99.51,
                    "250" => 155.61,
                    "315" => 247.06,
                ],
                "SDR21"=> [
                    "63" => 9.20,
                    "90" => 19.48,
                    "110" => 29.19,
                    "160" => 64.6,
                    "200" => 96.35,
                    "250" => 150.61,
                    "315" => 239.10,
                ],
                "SDR26" => [
                    "90" => 19.48,
                    "110" => 29.19,
                    "160" => 64.60,
                    "200" => 96.35,
                    "250" => 150.61,
                    "315" => 239.10,
                ]
            ]
        ];

        $type = $this->type;
        $dimension = $this->dimension;
        $ms = $this->ms;
        $debit = $sr_debit["type"][$type][$dimension];
        if ($debit !== null) {
            $debit = $debit * $ms;
            $add_data = new Debit();
            $add_data->type = $type;
            $add_data->dimension = $dimension;
            $add_data->ms = $ms;
            $add_data->debit = $debit;
            $add_data->save();
        } else {
            return null;
        }

        
        return $debit;

    }

}
