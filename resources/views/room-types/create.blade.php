@extends('layouts.app')
@section('title', 'Add Room Type')
@section('content')
<h2 class="mb-3">Add Room Type</h2>
<div class="card shadow-sm"><div class="card-body">
    @include('room-types.form', ['action' => route('room-types.store')])
</div></div>
@endsection