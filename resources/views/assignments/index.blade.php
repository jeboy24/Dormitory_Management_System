@extends('layouts.app')
@section('title', 'Assignments')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="mb-0">Room Assignments</h2>
    <a href="{{ route('assignments.create') }}" class="btn btn-primary">+ Assign Room</a>
</div>

<form method="GET" class="row g-2 mb-3">
    <div class="col-md-6">
        <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Search student name or number...">
    </div>
    <div class="col-md-3">
        <select name="status" class="form-select">
            <option value="">All statuses</option>
            <option value="active" @selected(request('status') === 'active')>Active</option>
            <option value="ended" @selected(request('status') === 'ended')>Ended</option>
        </select>
    </div>
    <div class="col-md-3 d-grid d-md-flex gap-2">
        <button class="btn btn-outline-primary">Filter</button>
        <a href="{{ route('assignments.index') }}" class="btn btn-outline-secondary">Reset</a>
    </div>
</form>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr><th>Student</th><th>Room</th><th>Check-in</th><th>Check-out</th><th>Status</th><th class="text-end">Actions</th></tr>
            </thead>
            <tbody>
                @forelse ($assignments as $a)
                    <tr>
                        <td class="fw-semibold">{{ $a->student->full_name }}</td>
                        <td>{{ $a->room->room_number }} <span class="text-muted small">({{ $a->room->roomType->name }})</span></td>
                        <td>{{ $a->check_in_date->format('M d, Y') }}</td>
                        <td>{{ $a->check_out_date?->format('M d, Y') ?? '—' }}</td>
                        <td><span class="badge {{ $a->status === 'active' ? 'bg-success' : 'bg-secondary' }}">{{ ucfirst($a->status) }}</span></td>
                        <td class="text-end text-nowrap">
                            <a href="{{ route('assignments.show', $a) }}" class="btn btn-sm btn-outline-secondary">View</a>
                            <a href="{{ route('assignments.edit', $a) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            @include('partials.delete-btn', [
                                'action'  => route('assignments.destroy', $a),
                                'name'    => $a->student->full_name . ' → Room ' . $a->room->room_number,
                                'warning' => 'All payments linked to this assignment will also be deleted.',
                            ])
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">No assignments found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $assignments->links() }}</div>
@endsection