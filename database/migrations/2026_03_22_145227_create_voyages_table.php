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
        Schema::create('voyages', function (Blueprint $table) {
            $table->id();

            $table->foreignId('vehicule_id')->constrained()->cascadeOnDelete();
            $table->foreignId('chauffeur_id')->constrained()->cascadeOnDelete();

            $table->dateTime('date_depart');
            $table->string('destination');
            $table->integer('nb_passagers');

            $table->enum('type', ['voyage','maintenance'])->default('voyage');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voyages');
    }
};
