<?php

namespace Database\Factories;

use App\Models\RoomType;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomFactory extends Factory
{
    public function definition(): array
    {
        return [
            'room_type_id' => RoomType::factory(),
            'room_number'  => fake()->unique()->bothify('R-###'),
            'floor'        => fake()->numberBetween(1, 5),
            'status'       => 'available',
        ];
    }
}