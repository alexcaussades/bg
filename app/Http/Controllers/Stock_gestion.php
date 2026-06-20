<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Models\StockToken;

class Stock_gestion extends Controller
{
    
    public function index()
    {
        return view('stock.index');
    }

    public function create()
    {
        return view('stock.create');
    }

    public function edit(string $name)
    {
        return view('stock.edit', compact('name'));
    }
    
    public function show(string $name)
    {
        return view('stock.show', compact('name'));
    }

    public function sortie(string $name)
    {
        return view('stock.sortie', compact('name'));
    }

    public function last10Sortie()
    {
        return view('stock.last10Sortie');
    }

    /** Qrcode pour la sortie du stock sans compte utilisateur */

    public function sortieQrcode(string $name)
    {
        return view('stock.sortieQrcode', compact('name'));
    }

    public function token(Request $request)
    {
        if (!Cookie::has('token_stock')) {
             /** crée une méthode pour générer un token aléatoire */
            $date = Carbon::now("Europe/Paris");
            $token = bin2hex(random_bytes(16));
            Cookie::forget('token_stock'); // Supprime le cookie existant
            Session::forget('token_stock'); // Supprime la session existante
            Cookie::queue('token_stock', json_encode(["valeur" => $token, "expire" => $date->addMinutes(540)]), 540); // Le cookie expire après 540 minutes
            $bdd_token = new StockToken();
            $bdd_token->store($token, now()->addMinutes(540), $request->ip(), $request->userAgent(), $request->header('referer'));

            return redirect()->route('stock.index')->with('success', 'Token généré avec succès.');

        } else {
            $this->tokenCheck($request);
        }
              
    }

    public function tokenCheck(Request $request)
    {
        $date = Carbon::now("Europe/Paris");
        /** Décode le cookie JSON pour obtenir la valeur du token */
        $data = json_decode(Cookie::get('token_stock'), true);

        /** Test de la date et de l'heure d'expiration */
        $expire = Carbon::parse($data['expire'], "Europe/Paris");

        /** Calcule du temps restant */
        $heure = $date->diffInHours($expire);
        $heure = explode(".", $heure);
       
        $info = $heure[0]." heures et ".($date->diffInMinutes($expire) % 60)." minutes restantes.";

        $bdd_token = new StockToken();
        $i = $bdd_token->getToken($data['valeur']);
        
        /** Start session */

        Session::put('token_stock_id', $i->id);
        Session::put('token_stock', $i->token);
        Session::put('token_stock_expire', $i->expire_at);
        Session::put('token_stock_expire_time', $info);

        $bdd_token->last_updated_token();


        if ($date->lessThanOrEqualTo($expire)) { 
            return response()->json(['status' => 'success', 'message' => 'Token valide.', 'expire' => $data['expire'], 'remaining' => $info]);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Token invalide.']);
        }
    }

}
