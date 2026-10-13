<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') | Dormitory Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">🏠 Dormitory MS</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav ms-auto">
                @php
                    $links = [
                        'dashboard'     => ['Dashboard', 'dashboard'],
                        'students.*'    => ['Students', 'students.index'],
                        'room-types.*'  => ['Room Types', 'room-types.index'],
                        'rooms.*'       => ['Rooms', 'rooms.index'],
                        'assignments.*' => ['Assignments', 'assignments.index'],
                        'payments.*'    => ['Payments', 'payments.index'],
                    ];
                @endphp
                @foreach ($links as $pattern => [$label, $route])
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs($pattern) ? 'active fw-semibold' : '' }}"
                           href="{{ route($route) }}">{{ $label }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</nav>

<main class="container pb-5">
    @include('partials.alerts')
    @yield('content')
</main>

{{-- Shared delete confirmation modal --}}
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" id="deleteForm" class="modal-content">
            @csrf
            @method('DELETE')
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="mb-1">Are you sure you want to delete <strong id="deleteName"></strong>?</p>
                <p class="text-danger small mb-0" id="deleteWarning"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger">Delete</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('deleteModal').addEventListener('show.bs.modal', function (event) {
        const btn = event.relatedTarget;
        document.getElementById('deleteForm').action = btn.dataset.action;
        document.getElementById('deleteName').textContent = btn.dataset.name;
        document.getElementById('deleteWarning').textContent = btn.dataset.warning || '';
    });
</script>
</body>
</html>