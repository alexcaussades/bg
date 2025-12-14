<?php

namespace App\Http\Controllers;

use App\Models\KizeoModel as Kizeo;
use App\Models\puits_lix as PuitsLix;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PHPUnit\Framework\Constraint\RegularExpression;

use function Laravel\Prompts\error;

class KizeoController extends Controller
{
    
    public function import_kizeo(Request $request)
    {
        // validation de plusieurs fichiers à la fois

        $request->validate([
            'bassin_file' => 'file|mimes:xlsx,csv',
            'ttcr_file' => 'file|mimes:xlsx,csv',
            'biogaz_file' => 'file|mimes:xlsx,csv',
            'bg500_vapo_file' => 'file|mimes:xlsx,csv',
            'bg1000_file' => 'file|mimes:xlsx,csv',
            'puits_lix' => 'file|mimes:xlsx,csv',
            'option' => 'nullable|boolean',

        ]);
        $request->validate([
            'date' => 'required',
        ]);

        $files = [
            $request->file('bassin_file'),
            $request->file('ttcr_file'),
            $request->file('biogaz_file'),
            $request->file('bg500_vapo_file'),
            $request->file('bg1000_file'),
            $request->file('puits_lix'),
        ];        

        $date = $request->date;
        $option = $request->option ? 1 : 0;
        
        
        $date = Carbon::createFromFormat('Y-m-d', $date)->format('d/m/Y');

            if ($files[1] != null) {
                $this->import_kizeo_ttcr($request, $files[1], $date);
            }
            if ($files[2] != null) {
                $this->import_kizeo_biogaz($request, $files[2], $date);
            }
            if ($files[0] != null) {
                // voir si c'est le bon fichier qui est importé
               $this->import_kizeo_bassin($request, $files[0], $date);
            }
            if ($files[3] != null) {
                $this->import_kizeo_Torch_Vapo($request, $files[3], $date);
            }
            if ($files[4] != null) {
                // A implémenter plus tard pour BG1000
            }
            if ($files[5] != null) {
                // A implémenter plus tard pour Puits de lixiviation
                $this->import_kizeo_puits_lix($request, $files[5], $date, $option);
            }
    
        return redirect()->back()->with('success', 'Fichiers importés avec succès.');
    }

    public function import_kizeo_bassin(Request $request, $file, $date)
    {      

        if ($file) {
            $spreadsheet = new Spreadsheet();
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
            $data = $spreadsheet->getActiveSheet()->toArray();
            $data = array_slice($data, 1); // Supprimer la première ligne (en-têtes)
            foreach ($data as $row) {
                $item = [
                    "Created_by" => $row[6],
                    "Date_de_mesure" => $date,
                    "Bassin_1" => $row[7],
                    "Commentaire_bassin_1" => $row[10],
                    "Bassin_2" => $row[11],
                    "Commentaire_bassin_2" => $row[14],
                    "Bassin_3" => $row[15],
                    "Commentaire_bassin_3" => $row[18],
                ];
            }
            $kizeo = new Kizeo();
            $kizeo->StoreBassin($item);

        return redirect()->back()->with('success', 'Fichier importé avec succès.');
    }
    }

    public function import_kizeo_Torch_Vapo(Request $request, $file, $date)
    {
    
        if ($file) {
            $spreadsheet = new Spreadsheet();
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
            $data = $spreadsheet->getActiveSheet()->toArray();
            $data = array_slice($data, 1); // Supprimer la première ligne (en-têtes)
            $regex_QMES = "/[0-9]{3}/";
            $regex_Qbch4 = "/[0-9]{3}/";
            
            foreach ($data as $row) {
                
                $item = [
                    "Created_by" => $row[6],
                    // recuper la date de la celliule 4
                    "Date_de_mesure" => $date,
                    "ft_heure_Torch" => $row[7],
                    "ft_heure_Vapo" => $row[8],
                    "Temperature_Torch" => $row[9],
                    "Debit_Torch" => $row[10],
                    "Totalisateur_Vapo" => $row[13],
                    "Commentaire_caisson_vapo" => $row[15],
                    "Qmes" => $row[16],
                    "QbCH" => $row[17],
                    "Volume_contine_VB" => $row[18],
                    "commentaire_fuji" => $row[20] ?? null,
                ];
            }
            $kizeo = new Kizeo();
            $kizeo->StoreTorch($item);

        return redirect()->back()->with('success', 'Fichier importé avec succès.');
    }
    }

    public function import_kizeo_ttcr(Request $request, $file, $date)
    {
        
        if ($file) {
            $spreadsheet = new Spreadsheet();
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
            $data = $spreadsheet->getActiveSheet()->toArray();
            $data = array_slice($data, 1); // Supprimer la première ligne (en-têtes)
            $regex_replissage = "/[a-zA-Z]{1}/";
            $regex_replissage_2 = "/[0-9]{1}[.][0-9]{1,}/";
            foreach ($data as $row) {
                $item = [
                    "Created_by" => $row[6],
                    // recuper la date de la celliule 4
                    "Date_de_mesure" => $date,
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
            
            $valeur_ttcr = [
                    "hauteur" => $item['niveau_remplissage'],
                    "compteur" => $item['totalisseur_mc'],
                ];

            // Enregistrement dans la base de données Kizeo
            $kizeo = new Kizeo();
            $kizeo->StoreTTCR($item);
            // Enregistrement dans la base de données TTCR en automatique via le model ttcr
            $ttcr = new TtcrController();
            $ttcr->Store_from_Kizeo_import_file($valeur_ttcr);

        

        return redirect()->back()->with('success', 'Fichier importé avec succès.');
    }
}

    public function import_kizeo_biogaz(Request $request, $file, $date)
    {
        if ($file) {
             $spreadsheet = new Spreadsheet();
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
            $data = $spreadsheet->getActiveSheet()->toArray();
            $data = array_slice($data, 1); // Supprimer la première ligne (en-têtes)
            
            foreach ($data as $row) {

                $item = [
                    "Created_by" => $row[6],
                    "Date_de_mesure" => $date,
                    "CHquatre" => $row[7],
                    "COdeux" => $row[8],
                    "Odeux" => $row[9],
                    "Depression" => $row[10],
                    "Commentaire_biogaz" => $row[14] ?? null,
                ];
            }
            $kizeo = new Kizeo();
            $kizeo->StoreBiogaz($item);
        }

        return redirect()->back()->with('success', 'Fichier importé avec succès.');

    }

    public function import_kizeo_puits_lix(Request $request, $file, $date, $option)
    {
        if ($file) {
             $spreadsheet = new Spreadsheet();
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
            $data = $spreadsheet->getActiveSheet()->toArray();
            $data = array_slice($data, 1); // Supprimer la première ligne (en-têtes)
            $items = [];
            foreach ($data as $row) {

                $item1 = [
                    "Created_by" => $row[6],
                    "Date_de_mesure" => $date,
                    "sonde" => $row[7],
                    "name" => "PL1",
                    "hauteur" => $row[8],
                    "mensuel" => $option ?? null,
                    
                ];

                $item2 = [
                    "Created_by" => $row[6],
                    "Date_de_mesure" => $date,
                    "sonde" => $row[7],
                    "name" => "PL2",
                    "hauteur" => $row[11],
                    "mensuel" => $option,
                    
                ];

                $item3 = [
                    "Created_by" => $row[6],
                    "Date_de_mesure" => $date,
                    "sonde" => $row[7],
                    "name" => "PL3",
                    "hauteur" => $row[53],
                    "mensuel" => $option ?? null,
                    
                ];

                $item4 = [
                    "Created_by" => $row[6],
                    "Date_de_mesure" => $date,
                    "sonde" => $row[7],
                    "name" => "PL4",
                    "hauteur" => $row[14],
                    "mensuel" => $option ?? null,
                    
                ];

                $item5 = [
                    "Created_by" => $row[6],
                    "Date_de_mesure" => $date,
                    "sonde" => $row[7],
                    "name" => "PL5",
                    "hauteur" => $row[50],
                    "mensuel" => $option ?? null,
                    
                ];

                $item6 = [
                    "Created_by" => $row[6],
                    "Date_de_mesure" => $date,
                    "sonde" => $row[7],
                    "name" => "PL6",
                    "hauteur" => $row[17],
                    "mensuel" => $option ?? null,
                    
                ];

                $item7 = [
                    "Created_by" => $row[6],
                    "Date_de_mesure" => $date,
                    "sonde" => $row[7],
                    "name" => "PL7",
                    "hauteur" => $row[47],
                    "mensuel" => $option ?? null,
                    
                ];

                $item8 = [
                    "Created_by" => $row[6],
                    "Date_de_mesure" => $date,
                    "sonde" => $row[7],
                    "name" => "PL8",
                    "hauteur" => $row[20],
                    "mensuel" => $option ?? null,
                    
                ];

                $item9 = [
                    "Created_by" => $row[6],
                    "Date_de_mesure" => $date,
                    "sonde" => $row[7],
                    "name" => "PL9",
                    "hauteur" => $row[44],
                    "mensuel" => $option ?? null,
                    
                ];

                $item10 = [
                    "Created_by" => $row[6],
                    "Date_de_mesure" => $date,
                    "sonde" => $row[7],
                    "name" => "PL10",
                    "hauteur" => $row[41],
                    "mensuel" => $option ?? null,
                    
                ];

                $item11 = [
                    "Created_by" => $row[6],
                    "Date_de_mesure" => $date,
                    "sonde" => $row[7],
                    "name" => "PL11",
                    "hauteur" => $row[23],
                    "mensuel" => $option ?? null,
                    
                ];

                $item12 = [
                    "Created_by" => $row[6],
                    "Date_de_mesure" => $date,
                    "sonde" => $row[7],
                    "name" => "PL12",
                    "hauteur" => $row[38],
                    "mensuel" => $option ?? null,
                    
                ];

                $item13 = [
                    "Created_by" => $row[6],
                    "Date_de_mesure" => $date,
                    "sonde" => $row[7],
                    "name" => "PL13",
                    "hauteur" => $row[26],
                    "mensuel" => $option ?? null,
                    
                ];

                $item14 = [
                    "Created_by" => $row[6],
                    "Date_de_mesure" => $date,
                    "sonde" => $row[7],
                    "name" => "PL14",
                    "hauteur" => $row[29],
                    "mensuel" => $option ?? null,
                    
                ];

                $item15 = [
                    "Created_by" => $row[6],
                    "Date_de_mesure" => $date,
                    "sonde" => $row[7],
                    "name" => "PL15",
                    "hauteur" => $row[32],
                    "mensuel" => $option ?? null,
                    
                ];

                $item16 = [
                    "Created_by" => $row[6],
                    "Date_de_mesure" => $date,
                    "sonde" => $row[7],
                    "name" => "PL16",
                    "hauteur" => $row[35],
                    "mensuel" => $option ?? null,
                    
                ];


                $items_array = array(
                    $item1,
                    $item2,
                    $item3,
                    $item4,
                    $item5,
                    $item6,
                    $item7,
                    $item8,
                    $item9,
                    $item10,
                    $item11,
                    $item12,
                    $item13,
                    $item14,
                    $item15,
                    $item16,
                );
                foreach ($items_array as $items) {
                    $puits_lix = new PuitsLix();
                    if ($items['hauteur'] != null) {
                    // rechercher si une entrée existe déjà pour cette date, ce nom et cette sonde
                    $existing_entry = PuitsLix::where('date', $items['Date_de_mesure'])
                        ->where('name', $items['name'])
                        ->where('hauteur', $items['hauteur'])
                        ->first();
                    if (!$existing_entry) {
                        $puits_lix->StorePuitsLix($items);
                    }
                }
            }          
        }
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

    public function get_mensuel_actual($mouth){
        $puits_lix = new PuitsLix();
        $pp = $puits_lix->get_mensuel_actual($mouth);
        return $pp;
    }

    public function get_puits_lix_name($name){
        $puits_lix = new PuitsLix();
        $pp = $puits_lix->get_name_lix($name);
        return $pp;
    }

    public function get_json_interface(){
        //recuperer le fichier json dans resources json intutuler hauteur_bassin.json
        
    }
}
