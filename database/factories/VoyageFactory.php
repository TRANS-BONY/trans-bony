<?php

namespace Database\Factories;

use App\Models\Voyage;
use Illuminate\Database\Eloquent\Factories\Factory;
class VoyageFactory extends Factory
{
    public function definition()
    {
        return [
            'vehicule_id' => \App\Models\Vehicule::factory(),
            'chauffeur_id' => \App\Models\Chauffeur::factory(),
            'date_depart' => $this->faker->dateTime(),
            'destination' => $this->faker->city(),
            'nb_passagers' => $this->faker->numberBetween(1,50),
'type' => $this->faker->randomElement(['voyage','maintenance'])
        ];
    }
}
