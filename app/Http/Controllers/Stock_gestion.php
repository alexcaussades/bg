<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        if (session()->has('token')) {
            session()->forget('token');
        }
        session()->put('token', $token);
        return view('stock.token', compact('token'));
    }
}
