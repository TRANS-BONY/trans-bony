<?php

namespace Database\Factories;

use App\Models\Maintenance;
use Illuminate\Database\Eloquent\Factories\Factory;
class MaintenanceFactory extends Factory
{
    public function definition()
    {
        return [
            'vehicule_id' => \App\Models\Vehicule::factory(),
            'type' => $this->faker->randomElement(['preventive','curative']),
            'date_prevue' => $this->faker->date(),
            'statut' => 'en cours',
            'cout' => $this->faker->randomFloat(2, 10000, 500000)
        ];
    }
}
