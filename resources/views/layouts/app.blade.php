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
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @yield('content')

    @yield('scripts')
</body>
</html>
