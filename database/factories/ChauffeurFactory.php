<?php

namespace Database\Factories;

use App\Models\Chauffeur;
use Illuminate\Database\Eloquent\Factories\Factory;
class ChauffeurFactory extends Factory
{
    public function definition()
    {
        return [
            'nom' => $this->faker->lastName(),
            'prenom' => $this->faker->firstName(),
'permis' => strtoupper($this->faker->unique()->bothify('PERM###')),
            'telephone' => $this->faker->phoneNumber(),
            'photo' => null,
            'actif' => true
        ];
    }
}
