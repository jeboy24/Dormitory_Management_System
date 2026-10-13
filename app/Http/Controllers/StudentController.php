<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $students = Student::with('activeAssignment.room')
            ->when($request->q, function ($query, $term) {
                $query->where(function ($q) use ($term) {
                    $q->where('first_name', 'like', "%{$term}%")
                      ->orWhere('last_name', 'like', "%{$term}%")
                      ->orWhere('student_number', 'like', "%{$term}%")
                      ->orWhere('email', 'like', "%{$term}%");
                });
            })
            ->orderBy('last_name')
            ->paginate(10)
            ->withQueryString();

        return view('students.index', compact('students'));
    }

    public function create()
    {
        return view('students.create', ['student' => new Student()]);
    }

    public function store(Request $request)
    {
        Student::create($this->validated($request));

        return redirect()->route('students.index')->with('success', 'Student added successfully.');
    }

    public function show(Student $student)
    {
        $student->load(['assignments.room.roomType', 'assignments.payments']);

        return view('students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $student->update($this->validated($request, $student));

        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        if ($student->assignments()->exists()) {
            return back()->with('error', 'Cannot delete this student because they have room assignment records.');
        }

        $student->delete();

        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }

    private function validated(Request $request, ?Student $student = null): array
    {
        return $request->validate([
            'student_number' => ['required', 'string', 'max:30', Rule::unique('students', 'student_number')->ignore($student)],
            'first_name'     => ['required', 'string', 'max:100'],
            'last_name'      => ['required', 'string', 'max:100'],
            'email'          => ['required', 'email', 'max:255', Rule::unique('students', 'email')->ignore($student)],
            'phone'          => ['nullable', 'string', 'max:20'],
            'gender'         => ['required', Rule::in(['Male', 'Female', 'Other'])],
            'address'        => ['nullable', 'string', 'max:255'],
        ]);
    }
}