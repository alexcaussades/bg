<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class category extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'title',
        'content',
    ];

    public static function store(array $data)
    {
        $validatedData = [
            'title' => $data['title'],
            'content' => $data['description'] ?? null,
        ];
        return DB::table('categories')->insert($validatedData);
    }

    public static function getAllCategories()
    {
        return DB::table('categories')->get();
    }
}
