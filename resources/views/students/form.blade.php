<form method="POST" action="{{ $action }}">
    @csrf
    @if ($student->exists) @method('PUT') @endif

    <div class="row">
        <div class="col-md-4 mb-3">
            <label class="form-label">Student Number</label>
            <input type="text" name="student_number" class="form-control @error('student_number') is-invalid @enderror"
                   value="{{ old('student_number', $student->student_number) }}" placeholder="e.g. 2026-00123">
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label">First Name</label>
            <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror"
                   value="{{ old('first_name', $student->first_name) }}">
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label">Last Name</label>
            <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror"
                   value="{{ old('last_name', $student->last_name) }}">
        </div>
    </div>
    <div class="row">
        <div class="col-md-5 mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email', $student->email) }}">
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                   value="{{ old('phone', $student->phone) }}">
        </div>
        <div class="col-md-3 mb-3">
            <label class="form-label">Gender</label>
            <select name="gender" class="form-select @error('gender') is-invalid @enderror">
                <option value="">-- Select --</option>
                @foreach (['Male', 'Female', 'Other'] as $g)
                    <option value="{{ $g }}" @selected(old('gender', $student->gender) === $g)>{{ $g }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label">Address</label>
        <input type="text" name="address" class="form-control @error('address') is-invalid @enderror"
               value="{{ old('address', $student->address) }}">
    </div>
    <a href="{{ route('students.index') }}" class="btn btn-secondary">Cancel</a>
    <button class="btn btn-primary">Save</button>
</form>