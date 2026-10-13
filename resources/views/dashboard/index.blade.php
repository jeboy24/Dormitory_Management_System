@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<h2 class="mb-4">Dashboard</h2>

<div class="row g-3 mb-4">
    @php
        $cards = [
            ['Students', $studentCount, 'primary', route('students.index')],
            ['Rooms', $roomCount, 'success', route('rooms.index')],
            ['Room Types', $roomTypeCount, 'info', route('room-types.index')],
            ['Active Assignments', $activeCount, 'warning', route('assignments.index', ['status' => 'active'])],
            ['Total Payments', '₱' . number_format($totalPayments, 2), 'danger', route('payments.index')],
        ];
    @endphp
    @foreach ($cards as [$label, $value, $color, $url])
        <div class="col-6 col-lg">
            <a href="{{ $url }}" class="text-decoration-none">
                <div class="card border-{{ $color }} h-100 shadow-sm">
                    <div class="card-body text-center">
                        <div class="text-muted small">{{ $label }}</div>
                        <div class="fs-3 fw-bold text-{{ $color }}">{{ $value }}</div>
                    </div>
                </div>
            </a>
        </div>
    @endforeach
</div>

<div class="row g-3">
    <div class="col-lg-6">
        <div class="card shadow-sm h-100">
            <div class="card-header d-flex justify-content-between">
                <span class="fw-semibold">Recent Assignments</span>
                <a href="{{ route('assignments.create') }}" class="btn btn-sm btn-primary">+ New</a>
            </div>
            <ul class="list-group list-group-flush">
                @forelse ($recentAssignments as $a)
                    <li class="list-group-item d-flex justify-content-between">
                        <a href="{{ route('assignments.show', $a) }}">{{ $a->student->full_name }}</a>
                        <span class="text-muted">Room {{ $a->room->room_number }}</span>
                    </li>
                @empty
                    <li class="list-group-item text-muted">No assignments yet.</li>
                @endforelse
            </ul>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card shadow-sm h-100">
            <div class="card-header d-flex justify-content-between">
                <span class="fw-semibold">Recent Payments</span>
                <a href="{{ route('payments.create') }}" class="btn btn-sm btn-primary">+ New</a>
            </div>
            <ul class="list-group list-group-flush">
                @forelse ($recentPayments as $p)
                    <li class="list-group-item d-flex justify-content-between">
                        <span>{{ $p->assignment->student->full_name }}</span>
                        <span class="fw-semibold">₱{{ number_format($p->amount, 2) }}</span>
                    </li>
                @empty
                    <li class="list-group-item text-muted">No payments yet.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection