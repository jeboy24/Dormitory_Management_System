@extends('layouts.app')
@section('title', 'Rooms')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="mb-0">Rooms</h2>
    <a href="{{ route('rooms.create') }}" class="btn btn-primary">+ Add Room</a>
</div>

<form method="GET" class="row g-2 mb-3">
    <div class="col-md-5">
        <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Search room number...">
    </div>
    <div class="col-md-4">
        <select name="room_type_id" class="form-select">
            <option value="">All room types</option>
            @foreach ($roomTypes as $t)
                <option value="{{ $t->id }}" @selected(request('room_type_id') == $t->id)>{{ $t->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3 d-grid d-md-flex gap-2">
        <button class="btn btn-outline-primary">Filter</button>
        <a href="{{ route('rooms.index') }}" class="btn btn-outline-secondary">Reset</a>
    </div>
</form>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr><th>Room</th><th>Type</th><th>Floor</th><th>Occupancy</th><th>Status</th><th class="text-end">Actions</th></tr>
            </thead>
            <tbody>
                @forelse ($rooms as $room)
                    @php $full = $room->active_assignments_count >= $room->roomType->capacity; @endphp
                    <tr>
                        <td class="fw-semibold">{{ $room->room_number }}</td>
                        <td>{{ $room->roomType->name }}</td>
                        <td>{{ $room->floor }}</td>
                        <td>
                            <span class="badge {{ $full ? 'bg-danger' : 'bg-success' }}">
                                {{ $room->active_assignments_count }}/{{ $room->roomType->capacity }}
                            </span>
                        </td>
                        <td>
                            <span class="badge {{ $room->status === 'available' ? 'bg-primary' : 'bg-secondary' }}">
                                {{ ucfirst($room->status) }}
                            </span>
                        </td>
                        <td class="text-end text-nowrap">
                            <a href="{{ route('rooms.show', $room) }}" class="btn btn-sm btn-outline-secondary">View</a>
                            <a href="{{ route('rooms.edit', $room) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            @include('partials.delete-btn', [
                                'action' => route('rooms.destroy', $room),
                                'name'   => 'Room ' . $room->room_number,
                            ])
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">No rooms found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $rooms->links() }}</div>
@endsection