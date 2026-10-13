@extends('layouts.app')
@section('title', 'Room ' . $room->room_number)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="mb-0">Room {{ $room->room_number }}</h2>
    <div>
        <a href="{{ route('rooms.edit', $room) }}" class="btn btn-outline-primary">Edit</a>
        <a href="{{ route('rooms.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body row">
        <div class="col-md-3"><div class="text-muted small">Type</div>{{ $room->roomType->name }}</div>
        <div class="col-md-3"><div class="text-muted small">Floor</div>{{ $room->floor }}</div>
        <div class="col-md-3"><div class="text-muted small">Monthly Rate</div>₱{{ number_format($room->roomType->monthly_rate, 2) }}</div>
        <div class="col-md-3"><div class="text-muted small">Status</div>{{ ucfirst($room->status) }}</div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header fw-semibold">Assignment History</div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead class="table-light"><tr><th>Student</th><th>Check-in</th><th>Check-out</th><th>Status</th></tr></thead>
            <tbody>
                @forelse ($room->assignments as $a)
                    <tr>
                        <td><a href="{{ route('students.show', $a->student) }}">{{ $a->student->full_name }}</a></td>
                        <td>{{ $a->check_in_date->format('M d, Y') }}</td>
                        <td>{{ $a->check_out_date?->format('M d, Y') ?? '—' }}</td>
                        <td><span class="badge {{ $a->status === 'active' ? 'bg-success' : 'bg-secondary' }}">{{ ucfirst($a->status) }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted py-3">No assignments yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection