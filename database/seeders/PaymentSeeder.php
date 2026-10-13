<?php

namespace Database\Seeders;

use App\Models\Assignment;
use App\Models\Payment;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        foreach (Assignment::with('room.roomType')->get() as $assignment) {
            $count = rand(1, 3);

            for ($i = 0; $i < $count; $i++) {
                Payment::factory()->create([
                    'assignment_id' => $assignment->id,
                    'amount'        => $assignment->room->roomType->monthly_rate,
                    'payment_date'  => $assignment->check_in_date->copy()->addMonths($i)->format('Y-m-d'),
                ]);
            }
        }
    }
}