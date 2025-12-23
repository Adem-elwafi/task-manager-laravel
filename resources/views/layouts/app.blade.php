<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Task Manager</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="container py-4">

    <nav class="mb-4">
        <a href="{{ route('projects.index') }}" class="btn btn-primary">Projects</a>
        <a href="{{ route('projects.create') }}" class="btn btn-success">New Project</a>
    </nav>

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @yield('content')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Delete confirmation script --}}
    <script>
        document.querySelectorAll('[data-confirm-delete]').forEach(function(elem) {
            elem.addEventListener('click', function(e) {
                if (!confirm('Are you sure you want to delete this task? This action cannot be undone.')) {
                    e.preventDefault();
                }
            });
        });
    </script>

    @yield('scripts')
</body>
</html>
