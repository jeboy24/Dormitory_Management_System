<form method="POST" action="{{ $action }}">
    @csrf
    @if ($room->exists) @method('PUT') @endif

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Room Number</label>
            <input type="text" name="room_number" class="form-control @error('room_number') is-invalid @enderror"
                   value="{{ old('room_number', $room->room_number) }}" placeholder="e.g. 101">
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Floor</label>
            <input type="number" name="floor" class="form-control @error('floor') is-invalid @enderror"
                   value="{{ old('floor', $room->floor) }}">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Room Type</label>
            <select name="room_type_id" class="form-select @error('room_type_id') is-invalid @enderror">
                <option value="">-- Select type --</option>
                @foreach ($roomTypes as $type)
                    <option value="{{ $type->id }}" @selected(old('room_type_id', $room->room_type_id) == $type->id)>
                        {{ $type->name }} (capacity {{ $type->capacity }})
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select @error('status') is-invalid @enderror">
                @foreach (['available', 'maintenance'] as $s)
                    <option value="{{ $s }}" @selected(old('status', $room->status) === $s)>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <a href="{{ route('rooms.index') }}" class="btn btn-secondary">Cancel</a>
    <button class="btn btn-primary">Save</button>
</form>