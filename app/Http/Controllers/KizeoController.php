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
                    "Date_de_mesure" => $row[5],
                    "Bassin_1" => $row[7],
                    "Commentaire_bassin_1" => $row[9],
                    "Bassin_2" => $row[10],
                    "Commentaire_bassin_2" => $row[12],
                    "Bassin_3" => $row[13],
                    "Commentaire_bassin_3" => $row[15],
                ];

            }
             // Convert the date to a Carbon instance and format it
            // Assuming the date is in the format 'm/d/Y H:i'
            // Adjust the format as necessary based on your data
            // Here we assume the date is in 'm/d/Y H:i' format
            $o = self::explode_the_date_time($item['Date_de_mesure']);
            $item['Date_de_mesure'] = $o;
            $kizeo = new Kizeo();
            $kizeo->StoreBassin($item);

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
                    "Date_de_mesure" => $row[5],
                    "ft_heure_Torch" => $row[7],
                    "ft_heure_Vapo" => $row[8],
                    "Temperature_Torch" => $row[9],
                    "Debit_Torch" => $row[10],
                    "Totalisateur_Vapo" => $row[13],
                    "Commentaire_caisson_vapo" => $row[15],
                    "Qmes" => $row[16],
                    "QbCH" => $row[17],
                    "Volume_contine_VB" => $row[18],
                    "commentaire_fuji" => $row[20],
                ];
            }
            // Convert the date to a Carbon instance and format it
            // Assuming the date is in the format 'm/d/Y H:i'
            // Adjust the format as necessary based on your data
            // Here we assume the date is in 'm/d/Y H:i' format
            $o = self::explode_the_date_time($item['Date_de_mesure']);
            $item['Date_de_mesure'] = $o;
            $kizeo = new Kizeo();
            $kizeo->StoreTorch($item);
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
                    "Date_de_mesure" => $row[5],
                    "niveau_remplissage" => $row[7],
                    "totalisseur_mc" => $row[8],
                    "Consigne_TTCR" => $row[11],
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
                    "commentaire_ttcr" => $row[24],
                ];

            }
            // Convert the date to a Carbon instance and format it
            // Assuming the date is in the format 'm/d/Y H:i'
            // Adjust the format as necessary based on your data
            // Here we assume the date is in 'm/d/Y H:i' format
            $o = self::explode_the_date_time($item['Date_de_mesure']);
            $item['Date_de_mesure'] = $o;

            $valeur_ttcr = [
                    "hauteur" => $item['niveau_remplissage'],
                    "compteur" => $item['totalisseur_mc'],
                ];

            //dd($valeur_ttcr['compteur']);
            // Enregistrement dans la base de données Kizeo
            $kizeo = new Kizeo();
            $kizeo->StoreTTCR($item);
            // Enregistrement dans la base de données TTCR en automatique via le model ttcr
            $ttcr = new TtcrController();
            $ttcr->Store_from_Kizeo_import_file($valeur_ttcr);

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
                    "Date_de_mesure" => $row[5],
                    "CHquatre" => $row[7],
                    "COdeux" => $row[8],
                    "Odeux" => $row[9],
                    "Depression" => $row[10],
                    "Commentaire_biogaz" => $row[14] ?? null,
                ];
            }
             // Convert the date to a Carbon instance and format it
            // Assuming the date is in the format 'm/d/Y H:i'
            // Adjust the format as necessary based on your data
            // Here we assume the date is in 'm/d/Y H:i' format
            
            $o = self::explode_the_date_time($item['Date_de_mesure']);
            $item['Date_de_mesure'] = $o;
            $kizeo = new Kizeo();
            $kizeo->StoreBiogaz($item);
        } elseif ($extension === 'csv') {
            error('Le format CSV n\'est pas supporté pour l\'importation des données Kizeo.');
        }

        return redirect()->back()->with('success', 'Fichier importé avec succès.');

    }

    public function explode_the_date_time($date)
    {
        $dateTime = explode("/", $date);
        //dd($dateTime);
        if($dateTime[1] >= "12") {
            $dateTime = Carbon::createFromFormat('m/d/Y H:i', $date, 'Europe/Paris');
        }
        else {
            $dateTime = $date;
        }
       return $dateTime;
    }

}
