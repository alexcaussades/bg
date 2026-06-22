<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Articles extends Model
{
    protected $table = 'articles';

    protected $fillable = [
        'reference',
        'category',
        'stock_minimum',
        'stock_actual',
        'title',
        'article_parent',
        'article_child',
    ];

    public static function store(array $data)
    {
        $validatedData = [
            'reference' => $data['reference'],
            'category' => $data['category'] ?? null,
            'stock_minimum' => $data['stock_minimum'] ?? null,
            'stock_actual' => $data['stock_actual'] ?? null,
            'title' => $data['title'] ?? null,
            'article_parent' => $data['article_parent'] ?? null,
            'article_child' => $data['article_child'] ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        return DB::table('articles')->insert($validatedData);
    }

    
}
