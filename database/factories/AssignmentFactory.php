<?php

namespace Database\Factories;

use App\Models\Room;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class AssignmentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'student_id'     => Student::factory(),
            'room_id'        => Room::factory(),
            'check_in_date'  => fake()->dateTimeBetween('-8 months', '-1 month')->format('Y-m-d'),
            'check_out_date' => null,
            'status'         => 'active',
        ];
    }

    public function ended(): static
    {
        return $this->state(function (array $attributes) {
            $checkIn = \Carbon\Carbon::parse($attributes['check_in_date']);

            return [
                'status'         => 'ended',
                'check_out_date' => $checkIn->copy()->addMonths(fake()->numberBetween(1, 5))->format('Y-m-d'),
            ];
        });
    }
}