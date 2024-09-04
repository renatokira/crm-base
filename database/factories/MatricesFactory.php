<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MatricesFactory extends Factory
{
    public function definition(): array
    {

        return [
            'name'        => fake()->name(),
            'threshold'   => fake()->randomElement([7, 15, 30, 50, 70, 75, 160, 200, 240, 320, 492, 1780]),
            'bandwidth'   => fake()->randomElement([1, 2, 100, 200, 300, 400, 500, 600]),
            'unit'        => 'GB',
            'description' => fake()->sentence(),
        ];
    }
}
