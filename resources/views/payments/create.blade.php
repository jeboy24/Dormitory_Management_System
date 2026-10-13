@extends('layouts.app')
@section('title', 'Record Payment')
@section('content')
<h2 class="mb-3">Record Payment</h2>
<div class="card shadow-sm"><div class="card-body">
    @include('payments.form', ['action' => route('payments.store')])
</div></div>
@endsection