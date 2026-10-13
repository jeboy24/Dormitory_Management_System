<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RoomTypeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'         => fake()->unique()->words(2, true) . ' Room',
            'description'  => fake()->sentence(),
            'monthly_rate' => fake()->randomElement([2000, 2500, 3000, 4500]),
            'capacity'     => fake()->numberBetween(1, 4),
        ];
    }
}