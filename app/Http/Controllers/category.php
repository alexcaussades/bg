<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class category extends Controller
{
    public function index()
    {
        return view('stock.articles.category');
    }

    public function create()
    {
        return view('stock.articles.category');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
        ]);
        
        \App\Models\category::store($validatedData);

        return redirect()->route('stock.articles.create')->with('success', 'Catégorie créée avec succès.');
    }

    public function show(int $id)
    {
        $category = \App\Models\category::findOrFail($id);
        return view('stock.articles.category', compact('category'));
    }

    public function edit(int $id)
    {
        $category = \App\Models\category::findOrFail($id);
        return view('stock.articles.category', compact('category'));
    }

    public function update(Request $request, int $id)
    {
        $category = \App\Models\category::findOrFail($id);

        $validatedData = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $category->update($validatedData);

        return redirect()->route('stock.articles.create')->with('success', 'Catégorie mise à jour avec succès.');
    }

    public function getAllCategories()
    {
        $categories = DB::table('category')->get("title");
        return $categories;
    }
}
