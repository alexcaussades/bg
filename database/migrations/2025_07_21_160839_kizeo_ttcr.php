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
        Schema::create('kizeo_ttcr', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('Created_by');
            $table->string('Date_de_mesure');
            $table->text('Consigne_TTCR')->nullable();
            $table->string('P1')->nullable();
            $table->string('P1_ph')->nullable();
            $table->string('P1_redox')->nullable();
            $table->string('P2')->nullable();
            $table->string('P2_ph')->nullable();
            $table->string('P2_redox')->nullable();
            $table->string('P3')->nullable();
            $table->string('P3_ph')->nullable();
            $table->string('P3_redox')->nullable();
            $table->string('P4')->nullable();
            $table->string('P4_ph')->nullable();
            $table->string('P4_redox')->nullable();
            $table->text('commentaire_ttcr')->nullable();
            $table->string('niveau_remplissage')->nullable();
            $table->string('totalisseur_mc')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kizeo_ttcr');
    }
};
