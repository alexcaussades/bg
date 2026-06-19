<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

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

    public function token()
    {
        /** crée une méthode pour générer un token aléatoire */
        $token = bin2hex(random_bytes(16));     
        session()->put('token', $token);
        Cookie::queue('token', $token, 60); // Le cookie expire après 10 minutes
        return session()->get('token');
    }

    public function tokenCheck()
    {
        //$token = $request->input('token');
        $tokenSession = session()->get('token');
        if (session()->has('token') && $tokenSession === Cookie::get('token')) {
            session()->forget('token');
            return response()->json(['status' => 'success', 'message' => 'Token valide, vous pouvez accéder à la gestion du stock.']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Token invalide, veuillez réessayer.']);
        }
    }

    public function fingerprintsearch()
    {
        /** retouve le fingerprint de l'appareil */
        $fingerprint = request()->header('User-Agent');
        return view('stock.fingerprintsearch', compact('fingerprint'));        
    }
}
