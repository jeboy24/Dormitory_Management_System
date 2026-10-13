<?php

namespace Database\Factories;

use App\Models\Assignment;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    public function definition(): array
    {
        $method = fake()->randomElement(['Cash', 'GCash', 'Bank Transfer']);

        return [
            'assignment_id'    => Assignment::factory(),
            'amount'           => fake()->randomElement([2000, 2500, 3000, 4500]),
            'payment_date'     => fake()->dateTimeBetween('-6 months', 'now')->format('Y-m-d'),
            'payment_method'   => $method,
            'reference_number' => $method === 'Cash' ? null : fake()->numerify('REF##########'),
            'remarks'          => fake()->optional(0.3)->sentence(4),
        ];
    }
}