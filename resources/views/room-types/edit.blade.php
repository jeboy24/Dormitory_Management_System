@extends('layouts.app')
@section('title', 'Edit Room Type')
@section('content')
<h2 class="mb-3">Edit Room Type</h2>
<div class="card shadow-sm"><div class="card-body">
    @include('room-types.form', ['action' => route('room-types.update', $roomType)])
</div></div>
@endsection