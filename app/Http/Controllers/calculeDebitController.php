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

    public function coeff()
    {
        $sr_coeff = [
            "type" => [
                "SDR11" => [
                    "32" => 1.90,
                    "40" => 3.00,
                    "63" => 7.50,
                    "90" => 15.3,
                    "110" => 22.9,
                    "160" => 48.4,
                    "200" => 75.7,
                    "250" => 118.4,
                    "315" => 187.9,
                ],
                "SDR17" => [
                    "32" =>2.20,
                    "40" => 3.50,
                    "63" => 8.80,
                    "90" => 18,
                    "110" => 26.84,
                    "125" => 34.03,
                    "160" => 56.85,
                    "200" => 88.78,
                    "250" => 138.85,
                    "315" => 220.40,
                ],
                "SDR33" => [
                    "63" => 9.80,
                    "90" => 20.14,
                    "110" => 30.11,
                    "160" => 63.79,
                    "200" => 99.51,
                    "250" => 155.61,
                    "315" => 247.06,
                ],
                "SDR21"=> [
                    "63" => 9.20,
                    "90" => 18.7,
                    "110" => 27.9,
                    "160" => 59.1,
                    "200" => 92.6,
                    "250" => 144.7,
                    "315" => 229.7,
                ],
                "SDR26" => [
                    "90" => 19.48,
                    "110" => 29.19,
                    "160" => 61.60,
                    "200" => 96.35,
                    "250" => 150.61,
                    "315" => 239.10,
                ]
            ]
        ];
        $type = $this->type;
        $dimension = $this->dimension;
        $coeff = $sr_coeff["type"][$type][$dimension];
        return $coeff;
    }

    public function calculeDebit()
    {
        // $sr_debit = [
        //     "type" => [
        //         "SDR11" => [
        //             "32" => 1.90,
        //             "40" => 3.00,
        //             "63" => 7.50,
        //             "90" => 15.3,
        //             "110" => 22.9,
        //             "160" => 48.4,
        //             "200" => 75.7,
        //             "250" => 118.4,
        //             "315" => 187.9,
        //         ],
        //         "SDR17" => [
        //             "32" =>2.20,
        //             "40" => 3.50,
        //             "63" => 8.80,
        //             "90" => 18,
        //             "110" => 26.84,
        //             "125" => 34.03,
        //             "160" => 56.85,
        //             "200" => 88.78,
        //             "250" => 138.85,
        //             "315" => 220.40,
        //         ],
        //         "SDR33" => [
        //             "63" => 9.80,
        //             "90" => 20.14,
        //             "110" => 30.11,
        //             "160" => 63.79,
        //             "200" => 99.51,
        //             "250" => 155.61,
        //             "315" => 247.06,
        //         ],
        //         "SDR21"=> [
        //             "63" => 9.20,
        //             "90" => 18.7,
        //             "110" => 27.9,
        //             "160" => 59.1,
        //             "200" => 92.6,
        //             "250" => 144.7,
        //             "315" => 229.7,
        //         ],
        //         "SDR26" => [
        //             "90" => 19.48,
        //             "110" => 29.19,
        //             "160" => 61.60,
        //             "200" => 96.35,
        //             "250" => 150.61,
        //             "315" => 239.10,
        //         ]
        //     ]
        // ];

        $type = $this->type;
        $dimension = $this->dimension;
        $ms = $this->ms;
        $debit = $this->coeff($type, $dimension);
        
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

    public function ajuster_debit($debit)
    {
        $debit = $debit;
        $type = $this->type;
        $dimension = $this->dimension;
        $coeff = $this->coeff($type, $dimension);
        $ms = $debit / $coeff;
        return $ms;
    }

}
