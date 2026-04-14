<?php

namespace Database\Seeders;

use App\Models\Vehicule;
use Illuminate\Database\Seeder;

class VehiculeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sample data instead of factory
        Vehicule::firstOrCreate(
            ['immatriculation' => 'AB-123-CD'],
            [
                'marque' => 'Mercedes',
                'modele' => 'Sprinter',
                'annee' => 2020,
                'capacite' => 15,
                'statut' => 'disponible'
            ]
        );

        // Add more manual records if needed
    }
}

