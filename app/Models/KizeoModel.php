<?php

namespace App\Models;

use App\Http\Controllers\KizeoController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class KizeoModel extends Model
{
    use HasFactory;

    protected $table = [
        'kizeo_bassin',
        'kizeo_torch',
        'kizeo_ttcr',
        'kizeo_biogaz'
    ];

    protected $fillable = [
        "Created_by",
        "Date_de_mesure",
        "Bassin_1",
        "Commentaire_bassin_1",
        "Bassin_2",
        "Commentaire_bassin_2",
        "Bassin_3",
        "Commentaire_bassin_3",
        "ft_heure_Torch",
        "ft_heure_Vapo",
        "Temperature_Torch",
        "Debit_Torch",
        "Totalisateur_Vapo",
        "Commentaire_caisson_vapo",
        "Qmes",
        "QbCH",
        "Volume_contine_VB",
        "commentaire_fuji",
        "niveau_remplissage",
        "totalisseur_mc",
        "Consigne_TTCR",
        "P1",
        "P1_ph",
        "P1_redox",
        "P2",
        "P2_ph",
        "P2_redox",
        "P3",
        "P3_ph",
        "P3_redox",
        "P4",
        "P4_ph",
        "P4_redox",
        "commentaire_ttcr",
        "CHquatre",
        "COdeux",
        "Odeux",
        "Depression",
        "Commentaire_biogaz"
    ];

    public function StoreBassin($data)
    { 
        DB::table('kizeo_bassin')->insert([
            'Created_by' => $data['Created_by'],
            'Date_de_mesure' => $data['Date_de_mesure'],
            'Bassin_1' => $data['Bassin_1'],
            'Commentaire_bassin_1' => $data['Commentaire_bassin_1'],
            'Bassin_2' => $data['Bassin_2'],
            'Commentaire_bassin_2' => $data['Commentaire_bassin_2'],
            'Bassin_3' => $data['Bassin_3'],
            'Commentaire_bassin_3' => $data['Commentaire_bassin_3']
        ]);
    }

    public function StoreTorch($data)
    {
        DB::table('kizeo_torch')->insert([
            'Created_by' => $data['Created_by'],
            'Date_de_mesure' => $data['Date_de_mesure'],
            'ft_heure_Torch' => $data['ft_heure_Torch'],
            'ft_heure_Vapo' => $data['ft_heure_Vapo'],
            'Temperature_Torch' => $data['Temperature_Torch'],
            'Debit_Torch' => $data['Debit_Torch'],
            'Totalisateur_Vapo' => $data['Totalisateur_Vapo'],
            'Commentaire_caisson_vapo' => $data['Commentaire_caisson_vapo'],
            'Qmes' => $data['Qmes'],
            'QbCH' => $data['QbCH'],
            'Volume_contine_VB' => $data['Volume_contine_VB'],
            'commentaire_fuji' => $data['commentaire_fuji']
        ]);
    }

    public function StoreTTCR($data)
    {
        DB::table('kizeo_ttcr')->insert([
            'Created_by' => $data['Created_by'],
            'Date_de_mesure' => $data['Date_de_mesure'],
            'niveau_remplissage' => $data['niveau_remplissage'],
            'totalisseur_mc' => $data['totalisseur_mc'],
            'Consigne_TTCR' => $data['Consigne_TTCR'],
        ]);
    }

    public function StoreBiogaz($data)
    {
        DB::table('kizeo_biogaz')->insert([
            'Created_by' => $data['Created_by'],
            'Date_de_mesure' => $data['Date_de_mesure'],
            'CHquatre' => $data['CHquatre'],
            'COdeux' => $data['COdeux'],
            'Odeux' => $data['Odeux'],
            'Depression' => $data['Depression'],
            'Commentaire_biogaz' => $data['Commentaire_biogaz']
        ]);
    }

    public function Preparation_rapport_journalier($date)
    {
        //like date_de_mesure pour rechercher les données
        //$date = $date->format('d-m-Y');
        $r = new KizeoController();
        $data = DB::table('kizeo_bassin')
            ->where('Date_de_mesure', 'like', '%' . $date . '%')
            ->get();
        $torchData = DB::table('kizeo_torch')
            ->where('Date_de_mesure', 'like', '%' . $date . '%')
            ->get();
        $ttcrData = DB::table('kizeo_ttcr')
            ->where('Date_de_mesure', 'like', '%' . $date . '%')
            ->get();
        $biogazData = DB::table('kizeo_biogaz')
            ->where('Date_de_mesure', 'like', '%' . $date . '%')
            ->get();
            
            if($data[0]->Bassin_1 != null && $data[0]->Bassin_2 != null && $data[0]->Bassin_3 != null){
                $niveauB1 = $r->get_hauteur_pourcentage_bassin("b1",$data[0]->Bassin_1);
                $niveauB2 = $r->get_hauteur_pourcentage_bassin("b2",$data[0]->Bassin_2);
                $data[0]->Bassin_1 = $data[0]->Bassin_1. " - " . $niveauB1["m3"].' m3 - '.$niveauB1['pourcentage'].' %';
                $data[0]->Bassin_2 = $data[0]->Bassin_2. " - " .$niveauB2["m3"].' m3 - '.$niveauB2['pourcentage'].' %';
            }else{
                return [
                    'bassin' => [],
                ];
            }
            

            return [
            'bassin' => $data ?? [],
            'torch' => $torchData ?? [],
            'ttcr' => $ttcrData ?? [],
            'biogaz' => $biogazData ?? [],
            "date" => $date 
        ];

        //Recherche d'informations dans la base de données Kizeo avec la date de mesure en fesant une requete LIKE 
        //return DB::table('kizeo_bassin')->where('Date_de_mesure', 'like', '%' . $date . '%')->get();
    }

    public function Preparation_rapport_hebdomadaire_torch_vapo($date_in, $date_out)
    {
        $data = DB::table('kizeo_torch')
            ->whereBetween('Date_de_mesure', [$date_in, $date_out])->orderBy('Date_de_mesure', 'asc')
            ->get()->toArray();

        $data2 = DB::table('kizeo_biogaz')
            ->whereBetween('Date_de_mesure', [$date_in, $date_out])->orderBy('Date_de_mesure', 'asc')
            ->get()->toArray();

        $data3 = DB::table('kizeo_ttcr')
            ->whereBetween('Date_de_mesure', [$date_in, $date_out])->orderBy('Date_de_mesure', 'asc')
            ->get()->toArray();

        $data4 = DB::table('kizeo_bassin')
            ->whereBetween('Date_de_mesure', [$date_in, $date_out])->orderBy('Date_de_mesure', 'asc')
            ->get()->toArray();

        return [
            'torch' => $data ?? [],
            'biogaz' => $data2 ?? [],
            'ttcr' => $data3 ?? [],
            'bassin' => $data4 ?? []
        ];
    }
    
}
