@extends('layouts.app')
@section('title', $student->full_name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="mb-0">{{ $student->full_name }}</h2>
    <div>
        <a href="{{ route('students.edit', $student) }}" class="btn btn-outline-primary">Edit</a>
        <a href="{{ route('students.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body row g-3">
        <div class="col-md-3"><div class="text-muted small">Student No.</div>{{ $student->student_number }}</div>
        <div class="col-md-3"><div class="text-muted small">Email</div>{{ $student->email }}</div>
        <div class="col-md-3"><div class="text-muted small">Phone</div>{{ $student->phone ?: '—' }}</div>
        <div class="col-md-3"><div class="text-muted small">Gender</div>{{ $student->gender }}</div>
        <div class="col-12"><div class="text-muted small">Address</div>{{ $student->address ?: '—' }}</div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between">
        <span class="fw-semibold">Room Assignments</span>
        <a href="{{ route('assignments.create') }}" class="btn btn-sm btn-primary">+ New Assignment</a>
    </div>
    <div class="table-responsive">
        <table class="table mb-0 align-middle">
            <thead class="table-light"><tr><th>Room</th><th>Check-in</th><th>Check-out</th><th>Status</th><th>Total Paid</th><th></th></tr></thead>
            <tbody>
                @forelse ($student->assignments as $a)
                    <tr>
                        <td>{{ $a->room->room_number }} ({{ $a->room->roomType->name }})</td>
                        <td>{{ $a->check_in_date->format('M d, Y') }}</td>
                        <td>{{ $a->check_out_date?->format('M d, Y') ?? '—' }}</td>
                        <td><span class="badge {{ $a->status === 'active' ? 'bg-success' : 'bg-secondary' }}">{{ ucfirst($a->status) }}</span></td>
                        <td>₱{{ number_format($a->payments->sum('amount'), 2) }}</td>
                        <td class="text-end"><a href="{{ route('assignments.show', $a) }}" class="btn btn-sm btn-outline-secondary">Details</a></td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-3">No assignments yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection