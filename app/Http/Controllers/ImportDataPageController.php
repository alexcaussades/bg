<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImportDataPageController extends Controller
{
    public function index()
    {
        return view('data.csv');
    }

    public function import(Request $request)
    {
        $request->validate([
            'fichier' => 'required|mimes:csv,txt',
        ]);

        (new DataPuitsController())->import($request);
        return redirect()->back()->with('success', 'Data imported successfully.');
    }

    public function borehole()
    {
        return view('data.borehole');
    }

    public function importBorehole(Request $request)
    {
        $request->validate([
            'fichier' => 'required|mimes:xml',
        ]);

        (new DataPuitsController())->borehole($request);
        return redirect()->back()->with('success', 'Data imported successfully.');
    }

    public function route()
    {
        return view('data.route');
    }

    public function importRoute(Request $request)
    {
        $request->validate([
            'fichier' => 'required|mimes:xml',
        ]);

        (new DataPuitsController())->route($request);
        return redirect()->back()->with('success', 'Data imported successfully.');
    }
}
