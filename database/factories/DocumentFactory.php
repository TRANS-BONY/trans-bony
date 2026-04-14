<?php

namespace Database\Factories;

use App\Models\Document;
use Illuminate\Database\Eloquent\Factories\Factory;
class DocumentFactory extends Factory
{
    public function definition()
    {
        return [
            'vehicule_id' => \App\Models\Vehicule::factory(),
            'type' => $this->faker->randomElement(['assurance','carte grise']),
            'date_emission' => $this->faker->date(),
            'date_expiration' => $this->faker->date(),
            'fichier' => 'doc.pdf'
        ];
    }
}
