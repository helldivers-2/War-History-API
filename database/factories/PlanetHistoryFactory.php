<?php

namespace Database\Factories;

use App\Models\PlanetStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PlanetStatus>
 */
class PlanetStatusFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'warId' => 801,
            'index' => fake()->numberBetween(0, 500),
            'owner' => 0,
            'health' => 1000000,
            'regenPerSecond' => 1388.99,
            'players' => 10,
            'created_at' => fake()->dateTime()
        ];
    }
}
