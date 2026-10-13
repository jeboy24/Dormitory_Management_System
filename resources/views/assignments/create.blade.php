@extends('layouts.app')
@section('title', 'Assign Room')
@section('content')
<h2 class="mb-3">Assign Room to Student</h2>
<div class="card shadow-sm"><div class="card-body">
    @include('assignments.form', ['action' => route('assignments.store')])
</div></div>
@endsection