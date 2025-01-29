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
        Schema::create('data_puits', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->foreignId('puits_id')->constrained('puits', "Name");
            $table->string('date');
            $table->string('ch4');
            $table->string('co2');
            $table->string('o2');
            $table->string('balance');
            $table->string('co');
            $table->string('h2');
            $table->string('h2s');
            $table->string('dépression');
            $table->string('temperature')->nullable();
            $table->string('m3/h')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_puits');
    }
};
