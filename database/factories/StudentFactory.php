<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'student_number' => fake()->unique()->numerify('2026-#####'),
            'first_name'     => fake()->firstName(),
            'last_name'      => fake()->lastName(),
            'email'          => fake()->unique()->safeEmail(),
            'phone'          => fake()->numerify('09#########'),
            'gender'         => fake()->randomElement(['Male', 'Female', 'Other']),
            'address'        => fake()->address(),
        ];
    }
}