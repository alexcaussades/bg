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
        Schema::table('puits', function (Blueprint $table) {
            $table->string('familles')->nullable();
            $table->string('lignes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('puits', function (Blueprint $table) {
            $table->dropColumn('familles');
            $table->dropColumn('lignes');
        });
    }
};
