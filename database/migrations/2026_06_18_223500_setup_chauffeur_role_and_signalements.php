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
        Schema::table('chauffeurs', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
        });

        Schema::create('signalements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('voyage_id')->constrained()->cascadeOnDelete();
            $table->foreignId('chauffeur_id')->constrained()->cascadeOnDelete();
            
            $table->enum('type', ['panne', 'accident', 'embouteillage', 'meteo', 'autre'])->default('autre');
            $table->text('description');
            $table->string('localisation')->nullable();
            $table->enum('gravite', ['faible', 'moyenne', 'critique'])->default('faible');
            $table->enum('statut', ['ouvert', 'pris_en_charge', 'resolu'])->default('ouvert');
            $table->string('photo')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('signalements');
        
        Schema::table('chauffeurs', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
        });
    }
};
