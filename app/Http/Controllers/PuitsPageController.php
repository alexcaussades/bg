<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PuitsPageController extends Controller
{
    public function show()
    {
        $puits = new puitsController();

        return view('puits.puits_show', [
            'puits' => $puits->show(),
            'retard' => $puits->recherche_puits(),
        ]);
    }

    public function retard()
    {
        return view('puits.retard_puits', [
            'retard' => (new puitsController())->recherche_puits(),
        ]);
    }

    public function edit($id)
    {
        return view('puits.puits_edit', [
            'id' => $id,
            'puit' => (new puitsController())->show_id($id),
        ]);
    }

    public function update(Request $request, $id)
    {
        (new puitsController())->update($id, [
            'type' => $request->type,
            'dimension' => $request->dimension,
            'familles' => $request->familles,
            'ligne' => $request->ligne,
        ]);

        return redirect()->route('puits.show');
    }

    public function desactive($id)
    {
        (new puitsController())->desactive($id);
        return redirect()->route('puits.show');
    }

    public function mesureLixivats()
    {
        $puits = new puitsController();

        // L'ancienne route ne retournait aucune réponse. On conserve ici
        // les données qu'elle préparait et on retourne une vue cohérente.
        return view('puits.puits_show', [
            'puits' => $puits->show(),
            'retard' => $puits->recherche_puits(),
        ]);
    }
}
