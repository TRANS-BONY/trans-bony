<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rapports', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->enum('type', ['mensuel', 'trimestriel', 'annuel', 'personnalisé'])->default('mensuel');
            $table->date('periode_debut');
            $table->date('periode_fin');
            $table->decimal('recettes_total', 15, 2)->default(0);
            $table->unsignedInteger('nb_voyages')->default(0);
            $table->unsignedInteger('nb_vehicules')->default(0);
            $table->unsignedInteger('nb_chauffeurs')->default(0);
            $table->text('notes')->nullable();
            $table->enum('statut', ['brouillon', 'publié'])->default('brouillon');
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rapports');
    }
};
