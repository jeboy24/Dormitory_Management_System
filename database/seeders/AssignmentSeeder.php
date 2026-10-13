<?php

namespace Database\Seeders;

use App\Models\Assignment;
use App\Models\Room;
use App\Models\Student;
use Illuminate\Database\Seeder;

class AssignmentSeeder extends Seeder
{
    public function run(): void
    {
        $students = Student::inRandomOrder()->get();
        $rooms    = Room::with('roomType')->withCount('activeAssignments')
                        ->where('status', 'available')->get();

        foreach ($students->take(30) as $student) {
            $room = $rooms->first(fn ($r) => $r->active_assignments_count < $r->roomType->capacity);
            if (! $room) {
                break;
            }

            Assignment::factory()->create([
                'student_id' => $student->id,
                'room_id'    => $room->id,
            ]);

            $room->active_assignments_count = $room->active_assignments_count + 1;
        }

        foreach ($students->slice(30, 6) as $student) {
            Assignment::factory()->ended()->create([
                'student_id' => $student->id,
                'room_id'    => $rooms->random()->id,
            ]);
        }
    }
}