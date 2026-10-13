@extends('layouts.app')
@section('title', 'Room Types')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="mb-0">Room Types</h2>
    <a href="{{ route('room-types.create') }}" class="btn btn-primary">+ Add Room Type</a>
</div>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr><th>Name</th><th>Monthly Rate</th><th>Capacity</th><th>Rooms</th><th class="text-end">Actions</th></tr>
            </thead>
            <tbody>
                @forelse ($roomTypes as $type)
                    <tr>
                        <td>
                            <div class="fw-semibold">{{ $type->name }}</div>
                            <div class="small text-muted">{{ $type->description }}</div>
                        </td>
                        <td>₱{{ number_format($type->monthly_rate, 2) }}</td>
                        <td>{{ $type->capacity }} {{ Str::plural('person', $type->capacity) }}</td>
                        <td>{{ $type->rooms_count }}</td>
                        <td class="text-end text-nowrap">
                            <a href="{{ route('room-types.edit', $type) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            @include('partials.delete-btn', [
                                'action' => route('room-types.destroy', $type),
                                'name'   => $type->name,
                            ])
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">No room types yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $roomTypes->links() }}</div>
@endsection