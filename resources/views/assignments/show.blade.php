@extends('layouts.app')
@section('title', 'Assignment Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="mb-0">Assignment Details</h2>
    <div>
        <a href="{{ route('assignments.edit', $assignment) }}" class="btn btn-outline-primary">Edit</a>
        <a href="{{ route('assignments.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body row g-3">
        <div class="col-md-3"><div class="text-muted small">Student</div>
            <a href="{{ route('students.show', $assignment->student) }}">{{ $assignment->student->full_name }}</a></div>
        <div class="col-md-3"><div class="text-muted small">Room</div>
            <a href="{{ route('rooms.show', $assignment->room) }}">{{ $assignment->room->room_number }}</a>
            ({{ $assignment->room->roomType->name }})</div>
        <div class="col-md-2"><div class="text-muted small">Check-in</div>{{ $assignment->check_in_date->format('M d, Y') }}</div>
        <div class="col-md-2"><div class="text-muted small">Check-out</div>{{ $assignment->check_out_date?->format('M d, Y') ?? '—' }}</div>
        <div class="col-md-2"><div class="text-muted small">Status</div>
            <span class="badge {{ $assignment->status === 'active' ? 'bg-success' : 'bg-secondary' }}">{{ ucfirst($assignment->status) }}</span></div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span class="fw-semibold">Payments — Total ₱{{ number_format($assignment->payments->sum('amount'), 2) }}</span>
        <a href="{{ route('payments.create', ['assignment_id' => $assignment->id]) }}" class="btn btn-sm btn-primary">+ Record Payment</a>
    </div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead class="table-light"><tr><th>Date</th><th>Amount</th><th>Method</th><th>Reference</th></tr></thead>
            <tbody>
                @forelse ($assignment->payments as $p)
                    <tr>
                        <td>{{ $p->payment_date->format('M d, Y') }}</td>
                        <td>₱{{ number_format($p->amount, 2) }}</td>
                        <td>{{ $p->payment_method }}</td>
                        <td>{{ $p->reference_number ?: '—' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted py-3">No payments yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection