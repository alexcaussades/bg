<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class ReglagePageController extends Controller
{
    public function index(Request $request)
    {
        $route = new regalgeController();
        $routes = $route->show();
        $viewData = ['route' => $routes];

        if ($request->cookie('last_id')) {
            $viewData['id'] = (int) $request->cookie('last_id') + 1;
        }

        return view('reglage.index', $viewData);
    }

    public function formule(Request $request)
    {
        $id = $request->id;
        $id2 = $id + 1;

        $reglage = new regalgeController();
        $route = $reglage->get_name($id);
        $name = $reglage->get_puit_name($route->Name);

        $last = DB::table('data_puits')
            ->where('puits_id', $route->Name)
            ->orderByDesc('id')
            ->get();

        $noteSr = (new NoteController())->puits_id($name[0]->id);
        $noteInfo = (new NoteController())->recherche_last($route->Name);

        if ($last->isEmpty()) {
            $last = null;
        }

        if (! $name[0]->type || ! $name[0]->dimension || ! $name[0]->lignes || ! $name[0]->familles) {
            return redirect()->route('reglage.edit', ['id' => $id]);
        }

        return view('reglage.formule', [
            'puit' => $name,
            'id' => $id,
            'last' => $last,
            'note' => $name[0]->id,
            'id2' => $id2,
            'note_sr' => $noteSr,
            'note_info' => $noteInfo,
        ]);
    }

    public function calculate(Request $request)
    {
        $request->validate([
            'taux' => 'required',
        ]);

        $type = $request->type;
        $dimension = $request->dimension;
        $reglage = new regalgeController();
        $route = $reglage->get_name($request->id);
        $name = $reglage->get_puit_name($route->Name);
        $note = $name[0]->id;

        $calule = round($request->ch4 * $request->ms / $request->taux, 2);

        $debit = new calculeDebitController($type, $dimension, $request->ms);
        $oldDebit = round($debit->calculeDebit(), 2);

        $debit = new calculeDebitController($type, $dimension, $calule);
        $newDebit = round($debit->calculeDebit(), 2);

        $request->session()->put('taux', $request->taux);
        Cookie::queue(Cookie::make('last_id', $request->id, 200, '/', null, false, false));

        $last = DB::table('data_puits')
            ->where('puits_id', $request->name)
            ->latest()
            ->get();

        $noteInfo = (new NoteController())->recherche_last($name[0]->Name);

        return view('reglage.formule', [
            'ancien' => $request->ms,
            'result' => $calule,
            'puit' => $name,
            'type' => $type,
            'dimension' => $dimension,
            'id' => $request->id,
            'old_debit' => $oldDebit,
            'newDebit' => $newDebit,
            'note' => $note,
            'last' => $last->isEmpty() ? null : $last,
            'note_info' => $noteInfo,
        ]);
    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $reglage = new regalgeController();
        $route = $reglage->get_name($id);
        $name = $reglage->get_puit_name($route->Name);

        return view('reglage.edit_formule', [
            'puit' => $name,
            'id' => $id,
            'route' => $reglage->show(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'type' => 'required',
            'dimension' => 'required',
            'familles' => 'required',
            'ligne' => 'required',
        ]);

        $reglage = new regalgeController();
        $getName = $reglage->get_puits_by_name_route($request->name);

        return redirect()->route('reglage.formule', ['id' => $getName[0]->id]);
    }

    public function ajuster(Request $request)
    {
        $id = $request->cookie('last_id');
        $reglage = new regalgeController();
        $route = $reglage->get_name($id);
        $name = $reglage->get_puit_name($route->Name);

        return view('reglage.ajuster', [
            'puit' => $name,
            'id' => $id,
        ]);
    }

    public function calculateAjustement(Request $request)
    {
        $request->validate([
            'debit' => 'required',
        ]);

        $reglage = new regalgeController();
        $route = $reglage->get_name($request->id);
        $name = $reglage->get_puit_name($route->Name);
        $note = $name[0]->id;

        $calculator = new calculeDebitController($request->type, $request->dimension, 0);
        $result = round($calculator->ajuster_debit($request->debit), 2);

        return view('reglage.ajuster', [
            'result' => $result,
            'puit' => $name,
            'id' => $request->id,
            'note' => $note,
        ]);
    }
}
