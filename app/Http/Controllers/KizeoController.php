<?php

namespace App\Http\Controllers;

use App\Models\KizeoModel as Kizeo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PHPUnit\Framework\Constraint\RegularExpression;

use function Laravel\Prompts\error;

class KizeoController extends Controller
{
    
    public function import_kizeo(Request $request)
    {
        $request->validate([
            'fichier' => 'required|file|mimes:xlsx,csv',
        ]);

        $file = $request->file('fichier');
        $extension = $file->getClientOriginalExtension();
        $name = $file->getClientOriginalName();
        // Debugging: Check the file name
        $name = preg_replace('/[^\x00-\x7F]/', '', $name);
        $name = trim($name);
        $recuperer = explode('_', $name);
        //dd($recuperer);
        if ($recuperer[3] == 'Saulaie') {
            $this->import_kizeo_ttcr($request);
        }
        if ($recuperer[3] == 'Biogaz') {
            $this->import_kizeo_biogaz($request);
        }
        if ($recuperer[3] == 'Bassins') {
            $this->import_kizeo_bassin($request);
        }
        if ($recuperer[3] == 'Torchre') {
            $this->import_kizeo_Torch_Vapo($request);
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

            $regex_QMES = "/[0-9]{3}/";
            $regex_Qbch4 = "/[0-9]{3}/";

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

            if (preg_match($regex_QMES, $item['Qmes'])) {
                // If Qmes is a number with 3 or more digits, we keep it as is
                $req = explode('.', $item['Qmes']);
                $item['Qmes'] = $req[0];
            }

            if (preg_match($regex_Qbch4, $item['QbCH'])) {
                // If QbCH is a number with 3 or more digits, we keep it as is
                $req = explode('.', $item['QbCH']);
                $item['QbCH'] = $req[0];
            }
            //dd($item);
            
            
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
            $regex_replissage = "/[a-zA-Z]{1}/";
            $regex_replissage_2 = "/[0-9]{1}[.][0-9]{1,}/";
            foreach ($data as $row) {
                $item = [
                    "Created_by" => $row[6],
                    // recuper la date de la celliule 4
                    "Date_de_mesure" => $row[5],
                    "niveau_remplissage" => $row[7],
                    "totalisseur_mc" => $row[8],
                    "Consigne_TTCR" => $row[11],
                ];
               
            }
            if(preg_match($regex_replissage, $item['niveau_remplissage'])) {
                // If the niveau_remplissage contains a letter, we assume it's a percentage
                $item['niveau_remplissage'] = str_replace('m', '', $item['niveau_remplissage']);
                $item['niveau_remplissage'] = str_replace('M', '', $item['niveau_remplissage']);
            }

            if(preg_match($regex_replissage_2, $item['niveau_remplissage'])) {
                // If the niveau_remplissage is a number with decimal places, we keep it as is
                $req = explode('.', $item['niveau_remplissage']);
                if($req[0] == 1) {
                    // If the first part is 0, we assume it's a percentage
                    $item['niveau_remplissage'] = $req[0]. $req[1];
                } elseif($req[0] == 2) {
                    // If the first part is 2, we assume it's a percentage
                    $item['niveau_remplissage'] = $req[0]. $req[1];
                } else {
                    // Otherwise, we keep the full value
                    $item['niveau_remplissage'] = $req[1];
                }
                
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


    public function Preparation_rapport_journalier($date)
    {
        $date_from = $date;
        $kizeo = new Kizeo();
        $data2= $kizeo->Preparation_rapport_journalier($date_from);
        return $data2;
    }

    public function preparation_rapport_hebdomadaire_torch_vapo($date_in, $date_out)
    {
        $kizeo = new Kizeo();
        $data2= $kizeo->Preparation_rapport_hebdomadaire_torch_vapo($date_in, $date_out);
        // Faire correspondre les $data2['torch']->dates_de_mesure avec le tableau torch et biogaz pour récupérer les données
        return $data2;
    }
}
