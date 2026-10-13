<?php

namespace Database\Seeders;

use App\Models\RoomType;
use Illuminate\Database\Seeder;

class RoomTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['name' => 'Single Room', 'description' => 'Private room for one student.',   'monthly_rate' => 4500, 'capacity' => 1],
            ['name' => 'Double Room', 'description' => 'Shared room for two students.',   'monthly_rate' => 3000, 'capacity' => 2],
            ['name' => 'Triple Room', 'description' => 'Shared room for three students.', 'monthly_rate' => 2500, 'capacity' => 3],
            ['name' => 'Quad Room',   'description' => 'Economy room for four students.', 'monthly_rate' => 2000, 'capacity' => 4],
        ];

        foreach ($types as $type) {
            RoomType::create($type);
        }
    }
}