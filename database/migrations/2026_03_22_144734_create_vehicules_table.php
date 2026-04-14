<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Traits\Auditable;



return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vehicules', function (Blueprint $table) {
                    $table->id();
                    $table->string('immatriculation')->unique();
                    $table->string('marque');
                    $table->string('modele');
                    $table->year('annee');
                    $table->integer('capacite');
                    $table->enum('statut',['disponible','mission','maintenance']);
                    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicules');
    }


};
