@extends('layouts.app')
@section('title', 'Add Student')
@section('content')
<h2 class="mb-3">Add Student</h2>
<div class="card shadow-sm"><div class="card-body">
    @include('students.form', ['action' => route('students.store')])
</div></div>
@endsection