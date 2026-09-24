<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TtcrPageController extends Controller
{
    public function index()
    {
        $ttcr = new TtcrController();

        return view('ttcr.index', [
            'ttcr' => $ttcr->index(),
            'ttcr_consignes' => $ttcr->TTCR_consignes_last(),
        ]);
    }

    public function create()
    {
        return view('ttcr.create');
    }

    public function store(Request $request)
    {
        (new TtcrController())->store($request);
        return redirect()->route('ttcr.index');
    }

    public function install()
    {
        (new TtcrController())->install_ttcr();
        return redirect()->route('ttcr.index');
    }
}
