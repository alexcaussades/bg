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
            $table->string("av_dep")->nullable();
            $table->string("av_m3h")->nullable();
            $table->string("ratio")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */

    public function down(): void
    {
        Schema::table('data_puits', function (Blueprint $table) {
            $table->dropColumn("av_dep");
            $table->dropColumn("av_m3h");
            $table->dropColumn("ratio");
        });
    }
};
