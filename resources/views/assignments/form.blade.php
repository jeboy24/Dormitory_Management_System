<form method="POST" action="{{ $action }}">
    @csrf
    @if ($assignment->exists) @method('PUT') @endif

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Student</label>
            <select name="student_id" class="form-select @error('student_id') is-invalid @enderror">
                <option value="">-- Select student --</option>
                @foreach ($students as $s)
                    <option value="{{ $s->id }}" @selected(old('student_id', $assignment->student_id) == $s->id)>
                        {{ $s->full_name }} ({{ $s->student_number }})
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Room</label>
            <select name="room_id" class="form-select @error('room_id') is-invalid @enderror">
                <option value="">-- Select room --</option>
                @foreach ($rooms as $r)
                    <option value="{{ $r->id }}" @selected(old('room_id', $assignment->room_id) == $r->id)>
                        Room {{ $r->room_number }} – {{ $r->roomType->name }}
                        ({{ $r->active_assignments_count }}/{{ $r->roomType->capacity }})
                        @if ($r->status === 'maintenance') [maintenance] @endif
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 mb-3">
            <label class="form-label">Check-in Date</label>
            <input type="date" name="check_in_date" class="form-control @error('check_in_date') is-invalid @enderror"
                   value="{{ old('check_in_date', $assignment->check_in_date?->format('Y-m-d') ?? now()->format('Y-m-d')) }}">
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label">Check-out Date <span class="text-muted small">(optional)</span></label>
            <input type="date" name="check_out_date" class="form-control @error('check_out_date') is-invalid @enderror"
                   value="{{ old('check_out_date', $assignment->check_out_date?->format('Y-m-d')) }}">
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select @error('status') is-invalid @enderror">
                @foreach (['active', 'ended'] as $st)
                    <option value="{{ $st }}" @selected(old('status', $assignment->status) === $st)>{{ ucfirst($st) }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <a href="{{ route('assignments.index') }}" class="btn btn-secondary">Cancel</a>
    <button class="btn btn-primary">Save</button>
</form>