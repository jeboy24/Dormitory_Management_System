<form method="POST" action="{{ $action }}">
    @csrf
    @if ($payment->exists) @method('PUT') @endif

    <div class="mb-3">
        <label class="form-label">Assignment (Student – Room)</label>
        <select name="assignment_id" class="form-select @error('assignment_id') is-invalid @enderror">
            <option value="">-- Select assignment --</option>
            @foreach ($assignments as $a)
                <option value="{{ $a->id }}" @selected(old('assignment_id', $payment->assignment_id) == $a->id)>
                    {{ $a->student->full_name }} – Room {{ $a->room->room_number }} ({{ ucfirst($a->status) }})
                </option>
            @endforeach
        </select>
    </div>
    <div class="row">
        <div class="col-md-4 mb-3">
            <label class="form-label">Amount (₱)</label>
            <input type="number" step="0.01" name="amount" class="form-control @error('amount') is-invalid @enderror"
                   value="{{ old('amount', $payment->amount) }}">
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label">Payment Date</label>
            <input type="date" name="payment_date" class="form-control @error('payment_date') is-invalid @enderror"
                   value="{{ old('payment_date', $payment->payment_date?->format('Y-m-d') ?? now()->format('Y-m-d')) }}">
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label">Method</label>
            <select name="payment_method" class="form-select @error('payment_method') is-invalid @enderror">
                <option value="">-- Select --</option>
                @foreach ($methods as $m)
                    <option value="{{ $m }}" @selected(old('payment_method', $payment->payment_method) === $m)>{{ $m }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-5 mb-3">
            <label class="form-label">Reference No. <span class="text-muted small">(optional)</span></label>
            <input type="text" name="reference_number" class="form-control @error('reference_number') is-invalid @enderror"
                   value="{{ old('reference_number', $payment->reference_number) }}">
        </div>
        <div class="col-md-7 mb-3">
            <label class="form-label">Remarks <span class="text-muted small">(optional)</span></label>
            <input type="text" name="remarks" class="form-control @error('remarks') is-invalid @enderror"
                   value="{{ old('remarks', $payment->remarks) }}">
        </div>
    </div>
    <a href="{{ route('payments.index') }}" class="btn btn-secondary">Cancel</a>
    <button class="btn btn-primary">Save</button>
</form>