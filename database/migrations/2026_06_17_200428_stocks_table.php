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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('name');
            $table->integer('minimal_quantity')->default(0);
            $table->integer('quantity')->default(0);
            $table->string('unit')->nullable();
            $table->longText('description')->nullable();
            $table->string('etat_stock')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
