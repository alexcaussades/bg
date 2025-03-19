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
        Schema::create('crj', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('torch');
            $table->string('temperature');
            $table->string('QB');
            $table->string('VB');
            $table->string('mode')->default("Depol");
            $table->string('slug')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crj');
    }
};
