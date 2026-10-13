@extends('layouts.app')
@section('title', 'Edit Student')
@section('content')
<h2 class="mb-3">Edit Student</h2>
<div class="card shadow-sm"><div class="card-body">
    @include('students.form', ['action' => route('students.update', $student)])
</div></div>
@endsection