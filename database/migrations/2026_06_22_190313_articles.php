<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('reference')->unique();
            $table->string('category')->nullable();
            $table->string('stock_minimum')->nullable();
            $table->string('stock_actual')->nullable();
            $table->string('title')->nullable();
            $table->string('article_parent')->nullable();
            $table->string('article_child')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
