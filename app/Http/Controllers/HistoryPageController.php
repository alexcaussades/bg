<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HistoryPageController extends Controller
{
    public function index()
    {
        return view('history.history', [
            'session' => (new DebitController())->orderby(),
        ]);
    }

    public function puits()
    {
        $puits = new puitsController();

        return view('history.by-puit', [
            'session' => $puits->show(),
            'favorite' => [
                'torch' => $puits->show_name('ALVTORCH'),
                'col1' => $puits->show_name('ALV0COL1'),
                'col2' => $puits->show_name('ALV0COL2'),
            ],
        ]);
    }

    public function puitsDetails(Request $request, $puit)
    {
        // Compatibilité avec l'ancien fonctionnement (?name=...) + correction
        // du fait que le paramètre {puit} était auparavant ignoré.
        $id = $request->input('name', $puit);

        $dataController = new DataPuitsController();
        $data = $dataController->show_id($id);
        $puitsController = new puitsController();
        $dataPuit = $puitsController->show_name($id);

        if ($data->isEmpty() || $dataPuit->isEmpty()) {
            return redirect()->route('history.puit');
        }

        return view('history.by-puit-id', [
            'data' => $data,
            'moyene' => $puitsController->moyene($id),
            'info' => $dataController->famille($data),
            'puit' => $dataPuit,
            'note' => (new NoteController())->puits_id($dataPuit[0]->id),
        ]);
    }
}
