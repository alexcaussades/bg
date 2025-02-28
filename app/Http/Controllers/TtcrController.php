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
        $old_ttcr = ttcr::latest()->first();
        $ttcr = new ttcr();
        $ttcr->compteur = $request->compteur;
        $ttcr->evolution = $request->compteur - $old_ttcr->compteur;
        $ttcr->save();
        return $ttcr;
    }

    public function install_ttcr()
    {
        if (ttcr::all()->count() == 0) {
            $ttcr = new ttcr();
            $ttcr->compteur = 7499;
            $ttcr->evolution = 0;
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
}
