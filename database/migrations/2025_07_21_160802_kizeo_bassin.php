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
        Schema::create('kizeo_bassin', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('Created_by');
            $table->string('Date_de_mesure');
            $table->string('Bassin_1')->nullable();
            $table->text('Commentaire_bassin_1')->nullable();
            $table->string('Bassin_2')->nullable();
            $table->text('Commentaire_bassin_2')->nullable();
            $table->string('Bassin_3')->nullable();
            $table->text('Commentaire_bassin_3')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kizeo_bassin');
    }
};
