<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $typeIds = RoomType::pluck('id');

        foreach (range(1, 5) as $floor) {
            foreach (range(1, 6) as $n) {
                Room::factory()->create([
                    'room_type_id' => $typeIds->random(),
                    'room_number'  => $floor . str_pad($n, 2, '0', STR_PAD_LEFT),
                    'floor'        => $floor,
                    'status'       => ($floor === 5 && $n === 6) ? 'maintenance' : 'available',
                ]);
            }
        }
    }
}