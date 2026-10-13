<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Room;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AssignmentController extends Controller
{
    public function index(Request $request)
    {
        $assignments = Assignment::with(['student', 'room.roomType'])
            ->when($request->status, fn ($q, $s) => $q->where('status', $s))
            ->when($request->q, function ($query, $term) {
                $query->whereHas('student', function ($q) use ($term) {
                    $q->where('first_name', 'like', "%{$term}%")
                      ->orWhere('last_name', 'like', "%{$term}%")
                      ->orWhere('student_number', 'like', "%{$term}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('assignments.index', compact('assignments'));
    }

    public function create()
    {
        return view('assignments.create', $this->formData(new Assignment(['status' => 'active'])));
    }

    public function store(Request $request)
    {
        Assignment::create($this->validated($request));

        return redirect()->route('assignments.index')->with('success', 'Room assigned successfully.');
    }

    public function show(Assignment $assignment)
    {
        $assignment->load(['student', 'room.roomType', 'payments']);

        return view('assignments.show', compact('assignment'));
    }

    public function edit(Assignment $assignment)
    {
        return view('assignments.edit', $this->formData($assignment));
    }

    public function update(Request $request, Assignment $assignment)
    {
        $assignment->update($this->validated($request, $assignment));

        return redirect()->route('assignments.index')->with('success', 'Assignment updated successfully.');
    }

    public function destroy(Assignment $assignment)
    {
        $assignment->delete(); // payments removed by cascading foreign key

        return redirect()->route('assignments.index')->with('success', 'Assignment (and its payments) deleted successfully.');
    }

    private function formData(Assignment $assignment): array
    {
        return [
            'assignment' => $assignment,
            'students'   => Student::orderBy('last_name')->get(),
            'rooms'      => Room::with('roomType')->withCount('activeAssignments')->orderBy('room_number')->get(),
        ];
    }

    private function validated(Request $request, ?Assignment $assignment = null): array
    {
        $validator = Validator::make($request->all(), [
            'student_id'     => ['required', 'exists:students,id'],
            'room_id'        => ['required', 'exists:rooms,id'],
            'check_in_date'  => ['required', 'date'],
            'check_out_date' => ['nullable', 'date', 'after_or_equal:check_in_date', 'required_if:status,ended'],
            'status'         => ['required', Rule::in(['active', 'ended'])],
        ], [
            'check_out_date.required_if' => 'Check-out date is required when the assignment has ended.',
        ]);

        $validator->after(function ($v) use ($request, $assignment) {
            if ($v->errors()->isNotEmpty() || $request->status !== 'active') {
                return;
            }

            $room = Room::with('roomType')->find($request->room_id);

            if ($room->status === 'maintenance') {
                $v->errors()->add('room_id', 'This room is under maintenance and cannot be assigned.');
            } else {
                $occupants = $room->activeAssignments()
                    ->when($assignment, fn ($q) => $q->where('id', '!=', $assignment->id))
                    ->count();

                if ($occupants >= $room->roomType->capacity) {
                    $v->errors()->add('room_id', "Room {$room->room_number} is already full ({$room->roomType->capacity} max).");
                }
            }

            $alreadyHasRoom = Assignment::where('student_id', $request->student_id)
                ->where('status', 'active')
                ->when($assignment, fn ($q) => $q->where('id', '!=', $assignment->id))
                ->exists();

            if ($alreadyHasRoom) {
                $v->errors()->add('student_id', 'This student already has an active room assignment.');
            }
        });

        return $validator->validate();
    }
}