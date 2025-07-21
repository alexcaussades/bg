<?php

namespace App\Http\Controllers;

use App\Models\KizeoModel as Kizeo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

use function Laravel\Prompts\error;

class KizeoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store()
    {
        //
    }

    public function lecture_bassin()
    {
        $bassin = Kizeo::where('type', 'bassin')->get();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set headers
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Nom');
        $sheet->setCellValue('C1', 'Type');

        // Populate data
        $row = 2;
        foreach ($bassin as $item) {
            $sheet->setCellValue('A' . $row, $item->id);
            $sheet->setCellValue('B' . $row, $item->name);
            $sheet->setCellValue('C' . $row, $item->type);
            $row++;
        }

    }

    public function import_kizeo_bassin(Request $request)
    {
        $request->validate([
            'fichier' => 'required|file|mimes:xlsx,csv',
        ]);

        $file = $request->file('fichier');
        $extension = $file->getClientOriginalExtension();

        if ($extension === 'xlsx') {
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
            $data = $spreadsheet->getActiveSheet()->toArray();

            foreach ($data as $row) {
                $item = [
                    "Created_by" => $row[6],
                    // recuper la date de la celliule 4
                    "Date_de_mesure" => $row[4],
                    //"Date de mesure" => $row[4],
                    "Bassin_1" => $row[7],
                    "Commentaire_bassin_1" => $row[9],
                    "Bassin_2" => $row[10],
                    "Commentaire_bassin_2" => $row[12],
                    "Bassin_3" => $row[13],
                    "Commentaire_bassin_3" => $row[15],
                ];
                
            }
            dd($item);
        } elseif ($extension === 'csv') {
           error('Le format CSV n\'est pas supporté pour l\'importation des données Kizeo.');
        }

        return redirect()->back()->with('success', 'Fichier importé avec succès.');
    }

    public function import_kizeo_Torch_Vapo(Request $request)
    {
        $request->validate([
            'fichier' => 'required|file|mimes:xlsx,csv',
        ]);

        $file = $request->file('fichier');
        $extension = $file->getClientOriginalExtension();

        if ($extension === 'xlsx') {
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
            $data = $spreadsheet->getActiveSheet()->toArray();

            foreach ($data as $row) {
                $item = [
                    "Created_by" => $row[6],
                    // recuper la date de la celliule 4
                    "Date_de_mesure" => $row[4],
                    "ft_heure_Torch" => $row[7],
                    "ft_heure_Vapo" => $row[8],
                    "Temparature_Torch" => $row[9],
                    "Debit_Torch" => $row[10],
                    "Totalisateur_Vapo" => $row[13],
                    "Commentaire" => $row[15],
                    "Qmes" => $row[16],
                    "QbCH" => $row[17],
                    "Volume_contine_VB" => $row[18],
                    "commentaire_fuji" => $row[20],
                ];
            }
            dd($item);
        } elseif ($extension === 'csv') {
            error('Le format CSV n\'est pas supporté pour l\'importation des données Kizeo.');
        }

        return redirect()->back()->with('success', 'Fichier importé avec succès.');
    }

    public function import_kizeo_ttcr(Request $request)
    {
        $request->validate([
            'fichier' => 'required|file|mimes:xlsx,csv',
        ]);

        $file = $request->file('fichier');
        $extension = $file->getClientOriginalExtension();

        if ($extension === 'xlsx') {
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
            $data = $spreadsheet->getActiveSheet()->toArray();

            foreach ($data as $row) {
                $item = [
                    "Created_by" => $row[6],
                    // recuper la date de la celliule 4
                    "Date_de_mesure" => $row[4],
                    "niveau_remplissage" => $row[7],
                    "totalisseur_mc" => $row[8],
                    "Consigne" => $row[11],
                    "P1" => $row[12],
                    "P1_ph" => $row[13],
                    "P1_redox" => $row[14],
                    "P2" => $row[15],
                    "P2_ph" => $row[16],
                    "P2_redox" => $row[17],
                    "P3" => $row[18],
                    "P3_ph" => $row[19],
                    "P3_redox" => $row[20],
                    "P4" => $row[21],
                    "P4_ph" => $row[22],
                    "P4_redox" => $row[23],
                    "commentaire" => $row[24],
                ];

                $valeur_ttcr = [
                    "niveau_remplissage" => $row[7],
                    "totalisseur_mc" => $row[8],                  
                ];
            }

            dd($item, $valeur_ttcr);
        } elseif ($extension === 'csv') {
            error('Le format CSV n\'est pas supporté pour l\'importation des données Kizeo.');
        }

        return redirect()->back()->with('success', 'Fichier importé avec succès.');
    }

    public function import_kizeo_biogaz(Request $request)
    {
        $request->validate([
            'fichier' => 'required|file|mimes:xlsx,csv',
        ]);

        $file = $request->file('fichier');
        $extension = $file->getClientOriginalExtension();

        if ($extension === 'xlsx') {
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
            $data = $spreadsheet->getActiveSheet()->toArray();

            foreach ($data as $row) {
                $item = [
                    "Created_by" => $row[6],
                    // recuper la date de la celliule 4
                    "Date_de_mesure" => $row[4],
                    "CHquatre" => $row[7],
                    "COdeux" => $row[8],
                    "Odeux" => $row[9],
                    "Depression" => $row[10],
                    "commentaire" => $row[12],
                ];
            }
            dd($item);
        } elseif ($extension === 'csv') {
            error('Le format CSV n\'est pas supporté pour l\'importation des données Kizeo.');
        }

        return redirect()->back()->with('success', 'Fichier importé avec succès.');

    }
}
