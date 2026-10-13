@extends('layouts.app')
@section('title', 'Payments')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="mb-0">Payments</h2>
    <a href="{{ route('payments.create') }}" class="btn btn-primary">+ Record Payment</a>
</div>

<form method="GET" class="row g-2 mb-3">
    <div class="col-md-9">
        <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Search student name or reference no...">
    </div>
    <div class="col-md-3 d-grid d-md-flex gap-2">
        <button class="btn btn-outline-primary">Search</button>
        <a href="{{ route('payments.index') }}" class="btn btn-outline-secondary">Reset</a>
    </div>
</form>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr><th>Date</th><th>Student</th><th>Room</th><th>Amount</th><th>Method</th><th>Reference</th><th class="text-end">Actions</th></tr>
            </thead>
            <tbody>
                @forelse ($payments as $p)
                    <tr>
                        <td>{{ $p->payment_date->format('M d, Y') }}</td>
                        <td class="fw-semibold">{{ $p->assignment->student->full_name }}</td>
                        <td>{{ $p->assignment->room->room_number }}</td>
                        <td>₱{{ number_format($p->amount, 2) }}</td>
                        <td>{{ $p->payment_method }}</td>
                        <td>{{ $p->reference_number ?: '—' }}</td>
                        <td class="text-end text-nowrap">
                            <a href="{{ route('payments.edit', $p) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            @include('partials.delete-btn', [
                                'action' => route('payments.destroy', $p),
                                'name'   => '₱' . number_format($p->amount, 2) . ' payment by ' . $p->assignment->student->full_name,
                            ])
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">No payments found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $payments->links() }}</div>
@endsection