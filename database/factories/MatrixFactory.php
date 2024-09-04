<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MatrixFactory extends Factory
{
    public function definition(): array
    {

        return [
            'name'           => fake()->name(),
            'threshold'      => fake()->randomElement([7, 15, 30, 50, 70, 75, 160, 200, 240, 320, 492, 1780]),
            'bandwidth'      => fake()->randomElement([100, 200, 300, 400, 500, 600]),
            'bandwidth_unit' => 'GB',
            'description'    => fake()->sentence(),
        ];
    }
}
