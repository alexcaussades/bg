<?php

namespace App\Http\Controllers;

use App\Models\puits;
use App\Models\data_puits;
use Illuminate\Http\Request;
use Dflydev\DotAccessData\Data;


class DataPuitsController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'fichier' => 'required|mimes:csv,txt',
        ]);

        $file = $request->file('fichier');
        $file = $file->storeAs('public', $file->getClientOriginalName());
        
        $file = storage_path('app/' . $file);
        if (($handle = fopen($file, 'r')) !== false) {
            // Première ligne (en-têtes)
            $ignored_lines = 11;

            for ($i = 0; $i < $ignored_lines; $i++) {
                fgetcsv($handle, 1000, ';');
            }
            
            // Lire chaque ligne du fichier après l'en-tête
            while (($data = fgetcsv($handle, 1000, ';')) !== false) {
                // $data contient chaque ligne sous forme de tableau avec les valeurs séparées par ';'
                // On peut ici traiter chaque ligne comme bon nous semble
                
                // Exemple de traitement : afficher chaque ligne
                if (count($data) > 1) {
                    if($data[0] === "********"){
                        continue;
                    }
                    if (data_puits::where('puits_id', $data[0])->where('date', $data[1])->exists()) {
                        continue;
                    }else{
                        data_puits::create([
                            'puits_id' => $data[0],
                            'date' => $data[1],
                            'ch4' => $data[2],
                            'co2' => $data[3],
                            'o2' => $data[4],
                            'balance' => $data[5],
                            'co' => $data[13],
                            'h2' => $data[15],
                            'h2s' => $data[14],
                            'dépression' => $data[23],
                            'temperature' => $data[25],
                            'm3/h' => $data[26],
                        ]);
                    }
                }
            }
            
            // Fermer le fichier après lecture
            fclose($handle);
        } else {
            echo "Impossible d'ouvrir le fichier.";
        }
        

        return redirect()->back()->with('success', 'Data imported successfully.');
    }

    public function show_id($data)
    {
        $puits = data_puits::where("puits_id", $data)->orderBy('id', 'DESC')->get();
        return $puits;        
    }

    public function famille($data)
    {
        $r = puits::where('Name', $data[0]["puits_id"])->first();
        if($r->familles != null){
            if($r->familles == "puit_lix"){
                $i = "Puit mixte";
            }
            if($r->familles == "prise_echantillion"){
                $i = "Prise d'échantillion";
            }
            if($r->familles == "puit"){
                $i = "Puit Biogaz";
            }
            if($r->familles == "tranche_drainante"){
                $i = "Tranche drainante";
            }
            if($r->familles == "ligne_principal"){
                $i = "Ligne principal";
            }
            if($r->familles == "collisseau"){
                $i = "Manchon de dilatation";
            }
            if($r->familles == "purge"){
                $i = "purge";
            }
        }
        $r = [
            'id' => $data[0]["puits_id"],
            'familles' => $i ?? null,
            'type' => $r->type,
            'dimension' => $r->dimension,
            'ligne' => $r->lignes ? "(".$r->lignes.")" : null
        ];
        return $r;      
    }

    
}
