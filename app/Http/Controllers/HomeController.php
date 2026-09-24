<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $dataPuitsCount = DB::table('puits')->count('id');
        $dataNoteCount = DB::table('notes')->where('status', 'active')->count('id');
        $dataDebitCount = DB::table('debit')->count('id');
        $dataDataCount = DB::table('data_puits')->count('id');

        $github = new GithubController();

        return view('home', [
            'puits' => $dataPuitsCount,
            'note' => $dataNoteCount,
            'debit' => $dataDebitCount,
            'data' => $dataDataCount,
            'reglage' => null,
            'last_release' => $github->release_last(),
            'open_issues' => $github->open_issues(),
        ]);
    }
}
