<form method="POST" action="{{ $action }}">
    @csrf
    @if ($roomType->exists) @method('PUT') @endif

    <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
               value="{{ old('name', $roomType->name) }}" placeholder="e.g. Double Occupancy">
    </div>
    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" rows="2" class="form-control @error('description') is-invalid @enderror">{{ old('description', $roomType->description) }}</textarea>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Monthly Rate (₱)</label>
            <input type="number" step="0.01" name="monthly_rate" class="form-control @error('monthly_rate') is-invalid @enderror"
                   value="{{ old('monthly_rate', $roomType->monthly_rate) }}">
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Capacity (persons per room)</label>
            <input type="number" name="capacity" class="form-control @error('capacity') is-invalid @enderror"
                   value="{{ old('capacity', $roomType->capacity) }}">
        </div>
    </div>
    <a href="{{ route('room-types.index') }}" class="btn btn-secondary">Cancel</a>
    <button class="btn btn-primary">Save</button>
</form>