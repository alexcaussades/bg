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
        Schema::table('data_puits', function (Blueprint $table) {
            // $table->string('m3/h')->change();
            $table->renameColumn('m3/h', 'm3h');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_puits', function (Blueprint $table) {
            $table->change("m3h", "m3/h");
        });
    }
};
