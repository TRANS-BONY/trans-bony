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
        Schema::create('affectations', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('voyage_id')->constrained()->cascadeOnDelete();
            $table->foreignId('chauffeur_id')->constrained()->cascadeOnDelete();
            $table->foreignId('vehicule_id')->constrained()->cascadeOnDelete();
            
            $table->enum('role_chauffeur', ['principal', 'relais', 'remplacant'])->default('principal');
            $table->integer('ordre')->default(1);
            $table->integer('km_depart_chauffeur')->nullable();
            $table->integer('km_fin_chauffeur')->nullable();
            
            $table->timestamps();

            // Un chauffeur ne peut être affecté qu'une fois au même voyage avec le même rôle (ou simplement une fois tout court)
            $table->unique(['voyage_id', 'chauffeur_id']);
        });

        // On rend chauffeur_id nullable dans voyages pour la transition
        Schema::table('voyages', function (Blueprint $table) {
            $table->unsignedBigInteger('chauffeur_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affectations');
        
        Schema::table('voyages', function (Blueprint $table) {
            $table->unsignedBigInteger('chauffeur_id')->nullable(false)->change();
        });
    }
};
