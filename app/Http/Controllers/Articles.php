<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Articles as ArticlesModel;
use Illuminate\Support\Facades\DB;
use App\Models\Category as CategoryModel;


class Articles extends Controller
{
    Public function index()
    {
        return view('stock.articles.index');
    }

    /**
     * Show the form for creating a new article.
     */
    public function create()
    {
        return view('stock.articles.create');
    }

    public function article_create()
    {
        return view('stock.articles.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'reference' => 'required|unique:articles',
            'category' => 'nullable|string',
            'stock_minimum' => 'nullable|string',
            'stock_actual' => 'nullable|string',
            'title' => 'nullable|string',
            'article_parent' => 'nullable|string',
            'article_child' => 'nullable|string',
        ]);

        DB::table('articles')->insert($validatedData);

        return redirect()->route('articles.index')->with('success', 'Article created successfully.');
    }

    public function show(int $id)
    {
        $article = ArticlesModel::findOrFail($id);
        return view('stock.articles.show', compact('article'));
    }

    public function edit(int $id)
    {
        $article = ArticlesModel::findOrFail($id);
        return view('stock.articles.edit', compact('article'));
    }

    public function update_stock(Request $request, int $id)
    {
        $article = ArticlesModel::findOrFail($id);

        $validatedData = $request->validate([
            'stock_actual' => 'nullable|string',
        ]);

        $article->update($validatedData);

        return redirect()->route('stock.articles.show', $article->id)->with('success', 'Stock updated successfully.');
    }
    
    public function sortie(Request $request, int $id)
    {
        $article = ArticlesModel::findOrFail($id);

        $validatedData = $request->validate([
            'stock_actual' => 'nullable|string',
        ]);

        // Decrease the stock_actual by the specified amount
        $article->stock_actual -= $validatedData['stock_actual'];
        $article->save();

        return redirect()->route('stock.articles.show', $article->id)->with('success', 'Stock decreased successfully.');
    }
}