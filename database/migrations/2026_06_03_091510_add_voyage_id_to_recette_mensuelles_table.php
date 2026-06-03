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
        Schema::table('recette_mensuelles', function (Blueprint $table) {
            $table->foreignId('voyage_id')->nullable()->constrained('voyages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recette_mensuelles', function (Blueprint $table) {
            $table->dropConstrainedForeignId('voyage_id');
        });
    }
};
