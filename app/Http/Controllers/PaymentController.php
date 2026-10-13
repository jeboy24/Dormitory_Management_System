<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PaymentController extends Controller
{
    private array $methods = ['Cash', 'GCash', 'Bank Transfer'];

    public function index(Request $request)
    {
        $payments = Payment::with('assignment.student', 'assignment.room')
            ->when($request->q, function ($query, $term) {
                $query->where(function ($outer) use ($term) {
                    $outer->where('reference_number', 'like', "%{$term}%")
                        ->orWhereHas('assignment.student', function ($q) use ($term) {
                            $q->where('first_name', 'like', "%{$term}%")
                              ->orWhere('last_name', 'like', "%{$term}%");
                        });
                });
            })
            ->latest('payment_date')
            ->paginate(10)
            ->withQueryString();

        return view('payments.index', compact('payments'));
    }

    public function create(Request $request)
    {
        $payment = new Payment(['assignment_id' => $request->assignment_id]);

        return view('payments.create', $this->formData($payment));
    }

    public function store(Request $request)
    {
        Payment::create($this->validated($request));

        return redirect()->route('payments.index')->with('success', 'Payment recorded successfully.');
    }

    public function edit(Payment $payment)
    {
        return view('payments.edit', $this->formData($payment));
    }

    public function update(Request $request, Payment $payment)
    {
        $payment->update($this->validated($request));

        return redirect()->route('payments.index')->with('success', 'Payment updated successfully.');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()->route('payments.index')->with('success', 'Payment deleted successfully.');
    }

    private function formData(Payment $payment): array
    {
        return [
            'payment'     => $payment,
            'assignments' => Assignment::with(['student', 'room'])->latest()->get(),
            'methods'     => $this->methods,
        ];
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'assignment_id'    => ['required', 'exists:assignments,id'],
            'amount'           => ['required', 'numeric', 'min:0.01', 'max:99999999'],
            'payment_date'     => ['required', 'date'],
            'payment_method'   => ['required', Rule::in($this->methods)],
            'reference_number' => ['nullable', 'string', 'max:50'],
            'remarks'          => ['nullable', 'string', 'max:255'],
        ]);
    }
}