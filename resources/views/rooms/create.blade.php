@extends('layouts.app')
@section('title', 'Add Room')
@section('content')
<h2 class="mb-3">Add Room</h2>
<div class="card shadow-sm"><div class="card-body">
    @include('rooms.form', ['action' => route('rooms.store')])
</div></div>
@endsection