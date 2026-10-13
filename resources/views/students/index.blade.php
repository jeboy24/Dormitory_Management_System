@extends('layouts.app')
@section('title', 'Students')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="mb-0">Students</h2>
    <a href="{{ route('students.create') }}" class="btn btn-primary">+ Add Student</a>
</div>

<form method="GET" class="row g-2 mb-3">
    <div class="col-md-9">
        <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Search name, student no. or email...">
    </div>
    <div class="col-md-3 d-grid d-md-flex gap-2">
        <button class="btn btn-outline-primary">Search</button>
        <a href="{{ route('students.index') }}" class="btn btn-outline-secondary">Reset</a>
    </div>
</form>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr><th>Student No.</th><th>Name</th><th>Email</th><th>Gender</th><th>Current Room</th><th class="text-end">Actions</th></tr>
            </thead>
            <tbody>
                @forelse ($students as $student)
                    <tr>
                        <td>{{ $student->student_number }}</td>
                        <td class="fw-semibold">{{ $student->full_name }}</td>
                        <td>{{ $student->email }}</td>
                        <td>{{ $student->gender }}</td>
                        <td>
                            @if ($student->activeAssignment)
                                <span class="badge bg-success">Room {{ $student->activeAssignment->room->room_number }}</span>
                            @else
                                <span class="badge bg-secondary">None</span>
                            @endif
                        </td>
                        <td class="text-end text-nowrap">
                            <a href="{{ route('students.show', $student) }}" class="btn btn-sm btn-outline-secondary">View</a>
                            <a href="{{ route('students.edit', $student) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            @include('partials.delete-btn', [
                                'action' => route('students.destroy', $student),
                                'name'   => $student->full_name,
                            ])
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">No students found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $students->links() }}</div>
@endsection