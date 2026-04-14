<?php

namespace Database\Factories;

use App\Models\RecetteMensuelle;
use Illuminate\Database\Eloquent\Factories\Factory;
class RecetteMensuelleFactory extends Factory
{
    public function definition()
    {
        return [
            'vehicule_id' => \App\Models\Vehicule::factory(),
            'montant' => $this->faker->randomFloat(2, 5000, 500000),
            'date' => $this->faker->date(),
            'type' => $this->faker->randomElement(['recette','depense'])
        ];
    }
}
