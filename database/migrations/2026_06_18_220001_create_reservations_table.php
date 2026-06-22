<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('voyage_id')->constrained()->cascadeOnDelete();
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->string('numero_billet')->unique()->comment('TB-2026-001234');

            // Passagers
            $table->unsignedSmallInteger('nb_passagers')->default(1);
            // Colis
            $table->unsignedSmallInteger('nb_colis')->default(0);
            $table->decimal('poids_colis_kg', 8, 2)->nullable();

            // Tarif
            $table->decimal('montant', 10, 2)->default(0);
            $table->enum('mode_paiement', ['espece', 'mobile_money', 'virement', 'en_attente'])
                  ->default('en_attente');
            $table->boolean('paye')->default(false);
            $table->timestamp('paye_le')->nullable();

            // Statut
            $table->enum('statut', ['en_attente', 'confirmee', 'embarquee', 'annulee', 'termine'])
                  ->default('en_attente');

            // Confort
            $table->string('siege')->nullable()->comment('Numéros de sièges ex: A1,A2');
            $table->decimal('bagage_kg', 8, 2)->nullable();
            $table->text('notes')->nullable();

            // Traçabilité
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['voyage_id', 'statut']);
            $table->index('numero_billet');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
