<?php

namespace App\Http\Controllers;

use App\Models\Debit;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DebitController extends Controller
{
    


    public function get_debit()
    {
        $debit = Debit::all();
        return $debit;
    } 

    public function store(Request $request)
    {
        $debit = new Debit();
        $debit->type = $request->type;
        $debit->dimension = $request->dimension;
        $debit->ms = $request->ms;
        $debit->debit = $request->debit;
        $debit->save();
        return redirect()->route('debit');
    }

    public function destroy($id)
    {
        $debit = Debit::find($id);
        $debit->delete();
        return redirect()->route('debit');
    }

    public function update(Request $request, $id)
    {
        $debit = Debit::find($id);
        $debit->type = $request->type;
        $debit->dimension = $request->dimension;
        $debit->ms = $request->ms;
        $debit->debit = $request->debit;
        $debit->save();
        return redirect()->route('debit');
    }


    public function orderby()
    {
        $debit = Debit::orderBy("id", "DESC")->get();
        return $debit;
    }

}
