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
        Schema::create('kizeo_puit_lix', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('name');
            $table->string("auteur")->nullable();
            $table->string("sonde")->nullable();
            $table->dateTime('date')->nullable();
            $table->string('hauteur')->nullable();
            $table->string('difference')->nullable();
            $table->boolean("mensuel")->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kizeo_puit_lix');
    }
};
