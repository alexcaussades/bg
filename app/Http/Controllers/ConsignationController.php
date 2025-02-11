<?php

namespace App\Http\Controllers;

use Nette\Utils\Image;
use App\Models\consignation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ConsignationController extends Controller
{
    public function index()
    {
        return view('consignation.index');
    }

    public function create(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'Équipements' => 'required',
            'info' => 'required',
            'photo' => 'image | mimes:jpeg,png,jpg,gif | max:18000'
        ]);

        if(!is_dir(storage_path('app/public/images'))){
            mkdir(storage_path('app/public/images'), 0777, true);
        }

        // Store the image in the public folder and get the path of the image
        $image = $request->file('photo');
        $image = $image->storeAs('images', $image->getClientOriginalName(), 'public');

        $consignation = consignation::create([
            'type' => $request->type,
            'Équipements' => $request->Équipements,
            'info' => $request->info,
            'photo' => $image
        ]);

        return response()->json($consignation);
    }

    public function show()
    {
        $note = DB::table('consignations')->get();
        return $note;
    }

    public function view($id)
    {
        $note = DB::table('consignations')->where('id', $id)->first();
        return $note;
    }
}
