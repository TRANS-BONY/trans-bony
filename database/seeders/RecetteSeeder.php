<?php

namespace Database\Seeders;

use App\Models\RecetteMensuelle;
use App\Models\Vehicule;
use Illuminate\Database\Seeder;

class RecetteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vehicules = Vehicule::all();

        if ($vehicules->isEmpty()) {
            return; // No vehicules, skip
        }

        $faker = fake();

        for ($i = 0; $i < 20; $i++) {
            RecetteMensuelle::create([
                'vehicule_id' => $vehicules->random()->id,
                'montant' => $faker->randomFloat(2, 5000, 150000),
                'date' => $faker->dateTimeBetween('-12 months')->format('Y-m-d'),
                'type' => $faker->randomElement(['recette', 'depense']),
            ]);
        }
    }
}
