<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OffreFactory extends Factory
{
    public function definition(): array
    {
        return [
            'titre'       => fake()->sentence(4),
            'description' => fake()->paragraph(),
            'localisation'=> fake()->city(),
            'type'        => fake()->randomElement(['CDI', 'CDD', 'stage']),
            'actif'       => true,
        ];
    }
}
