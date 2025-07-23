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
        Schema::create('kizeo_biogaz', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('Created_by');
            $table->string('Date_de_mesure');
            $table->string('CHquatre')->nullable();
            $table->string('COdeux')->nullable();
            $table->string('Odeux')->nullable();
            $table->string('Depression')->nullable();
            $table->text('Commentaire_biogaz')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kizeo_biogaz');
    }
};
