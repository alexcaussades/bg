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
        Schema::create('kizeo_torch', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('Created_by');
            $table->string('Date_de_mesure');
            $table->string('ft_heure_Torch')->nullable();
            $table->string('ft_heure_Vapo')->nullable();
            $table->string('Temperature_Torch')->nullable();
            $table->string('Debit_Torch')->nullable();
            $table->string('Totalisateur_Vapo')->nullable();
            $table->text('Commentaire_caisson_vapo')->nullable();
            $table->string('Qmes')->nullable();
            $table->string('QbCH')->nullable();
            $table->string('Volume_contine_VB')->nullable();
            $table->text('commentaire_fuji')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kizeo_torch');
    }
};
