<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DebitPageController extends Controller
{
    public function index(Request $request)
    {
        if (! $request->has(['type', 'dimension', 'ms'])) {
            return view('debit');
        }

        $debit = new calculeDebitController(
            $request->type,
            $request->dimension,
            $request->ms
        );

        return view('debit', [
            'result' => $debit->calculeDebit(),
            'session' => (new DebitController())->orderby(),
        ]);
    }
}
