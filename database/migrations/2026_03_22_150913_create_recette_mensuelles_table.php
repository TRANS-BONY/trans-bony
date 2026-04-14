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
        Schema::create('recette_mensuelles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicule_id');
            $table->decimal('montant',10,2);
            $table->date('date');
            $table->string('type'); // recette ou depense
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recette_mensuelles');
    }
};
