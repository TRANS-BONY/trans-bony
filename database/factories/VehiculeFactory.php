<?php

namespace Database\Factories;

use App\Models\Vehicule;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehiculeFactory extends Factory
{
    public function definition()
    {
        return [
            'immatriculation' => strtoupper($this->faker->bothify('??-###-??')),
            'marque' => $this->faker->randomElement(['Toyota','Nissan','Mercedes']),
            'modele' => $this->faker->word(),
            'annee' => $this->faker->year(),
            'capacite' => $this->faker->numberBetween(4, 60),
            'statut' => $this->faker->randomElement(['disponible','mission','maintenance'])
        ];
    }
}
