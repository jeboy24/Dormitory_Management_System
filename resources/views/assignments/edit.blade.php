@extends('layouts.app')
@section('title', 'Edit Assignment')
@section('content')
<h2 class="mb-3">Edit Assignment</h2>
<div class="card shadow-sm"><div class="card-body">
    @include('assignments.form', ['action' => route('assignments.update', $assignment)])
</div></div>
@endsection