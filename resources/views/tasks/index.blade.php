@extends('layouts.app')

@section('content')
    {{-- Page Header --}}
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('projects.index') }}" class="text-decoration-none">
                        <i class="bi bi-folder"></i> Projects
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('projects.show', $project->id) }}" class="text-decoration-none">
                        {{ $project->name }}
                    </a>
                </li>
                <li class="breadcrumb-item active">Tasks</li>
            </ol>
        </nav>
        
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
            <div>
                <h1 class="display-6 fw-bold mb-2">
                    <i class="bi bi-list-check text-primary me-2"></i>
                    Tasks: {{ $project->name }}
                </h1>
                <p class="text-muted mb-0">
                    Showing {{ $tasks->total() }} {{ Str::plural('task', $tasks->total()) }}
                </p>
            </div>
            @can('create', [App\Models\Task::class, $project])
                <a href="{{ route('projects.tasks.create', $project->id) }}" class="btn btn-success btn-lg">
                    <i class="bi bi-plus-circle me-2"></i>
                    New Task
                </a>
            @endcan
        </div>
    </div>

    {{-- Filters Card --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-light">
            <h5 class="mb-0 fw-semibold">
                <i class="bi bi-funnel text-primary me-2"></i>
                Filter & Search
            </h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('projects.tasks.index', $project->id) }}">
                <div class="row g-3">
                    {{-- Search --}}
                    <div class="col-md-4">
                        <label for="search" class="form-label fw-semibold">
                            <i class="bi bi-search me-1"></i>
                            Search
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" 
                                   name="search" 
                                   id="search"
                                   class="form-control" 
                                   placeholder="Search tasks..." 
                                   value="{{ request('search') }}">
                        </div>
                    </div>

                    {{-- Status Filter --}}
                    <div class="col-md-3">
                        <label for="status" class="form-label fw-semibold">
                            <i class="bi bi-hourglass-split me-1"></i>
                            Status
                        </label>
                        <select name="status" id="status" class="form-select">
                            <option value="">All Statuses</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                                Pending
                            </option>
                            <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>
                                In Progress
                            </option>
                            <option value="done" {{ request('status') == 'done' ? 'selected' : '' }}>
                                Done
                            </option>
                        </select>
                    </div>

                    {{-- Priority Filter --}}
                    <div class="col-md-3">
                        <label for="priority" class="form-label fw-semibold">
                            <i class="bi bi-exclamation-triangle me-1"></i>
                            Priority
                        </label>
                        <select name="priority" id="priority" class="form-select">
                            <option value="">All Priorities</option>
                            <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>
                                Low
                            </option>
                            <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>
                                Medium
                            </option>
                            <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>
                                High
                            </option>
                        </select>
                    </div>

                    {{-- Filter Button --}}
                    <div class="col-md-2">
                        <label class="form-label d-block">&nbsp;</label>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-filter me-2"></i>
                            Apply
                        </button>
                    </div>
                </div>

                {{-- Clear Filters --}}
                @if(request()->hasAny(['search', 'status', 'priority']))
                    <div class="mt-3">
                        <a href="{{ route('projects.tasks.index', $project->id) }}" 
                           class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-x-circle me-1"></i>
                            Clear All Filters
                        </a>
                    </div>
                @endif
            </form>
        </div>
    </div>

    {{-- Active Filters Display --}}
    @if(request()->hasAny(['search', 'status', 'priority']))
        <div class="mb-3">
            <div class="d-flex flex-wrap gap-2 align-items-center">
                <span class="text-muted small">Active filters:</span>
                @if(request('search'))
                    <span class="badge bg-primary">
                        <i class="bi bi-search me-1"></i>
                        "{{ request('search') }}"
                    </span>
                @endif
                @if(request('status'))
                    <span class="badge bg-info">
                        Status: {{ ucfirst(str_replace('_', ' ', request('status'))) }}
                    </span>
                @endif
                @if(request('priority'))
                    <span class="badge bg-warning text-dark">
                        Priority: {{ ucfirst(request('priority')) }}
                    </span>
                @endif
            </div>
        </div>
    @endif

    {{-- Tasks List --}}
    @forelse($tasks as $task)
        <x-task-card :task="$task" />
    @empty
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <i class="bi bi-inbox display-1 text-muted mb-3"></i>
                <h4 class="text-muted mb-3">
                    @if(request()->hasAny(['search', 'status', 'priority']))
                        No Tasks Match Your Filters
                    @else
                        No Tasks Found
                    @endif
                </h4>
                <p class="text-muted mb-4">
                    @if(request()->hasAny(['search', 'status', 'priority']))
                        Try adjusting your filters or clearing them to see more results
                    @else
                        Get started by creating your first task for this project
                    @endif
                </p>
                <div class="d-flex gap-2 justify-content-center">
                    @if(request()->hasAny(['search', 'status', 'priority']))
                        <a href="{{ route('projects.tasks.index', $project->id) }}" 
                           class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle me-2"></i>
                            Clear Filters
                        </a>
                    @endif
                    @can('create', [App\Models\Task::class, $project])
                        <a href="{{ route('projects.tasks.create', $project->id) }}" 
                           class="btn btn-success">
                            <i class="bi bi-plus-circle me-2"></i>
                            Create Task
                        </a>
                    @endcan
                </div>
            </div>
        </div>
    @endforelse

    {{-- Pagination --}}
    @if($tasks->hasPages())
        <div class="d-flex justify-content-center mt-4">
            <nav aria-label="Task pagination">
                {{ $tasks->withQueryString()->links() }}
            </nav>
        </div>
    @endif
@endsection