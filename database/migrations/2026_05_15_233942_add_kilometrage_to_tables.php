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
        Schema::table('vehicules', function (Blueprint $table) {
            $table->integer('kilometrage')->default(0)->after('capacite');
        });

        Schema::table('voyages', function (Blueprint $table) {
            $table->integer('km_depart')->nullable()->after('nb_passagers');
            $table->integer('km_arrivee')->nullable()->after('km_depart');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicules', function (Blueprint $table) {
            $table->dropColumn('kilometrage');
        });

        Schema::table('voyages', function (Blueprint $table) {
            $table->dropColumn(['km_depart', 'km_arrivee']);
        });
    }
};
