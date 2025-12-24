@extends('layouts.app')

@section('content')
    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-3">
        <div class="flex-grow-1">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('projects.index') }}" class="text-decoration-none">
                            <i class="bi bi-folder"></i> Projects
                        </a>
                    </li>
                    <li class="breadcrumb-item active">{{ $project->name }}</li>
                </ol>
            </nav>
            <h1 class="display-6 fw-bold mb-2">
                <i class="bi bi-folder-fill text-primary me-2"></i>
                {{ $project->name }}
            </h1>
        </div>
        <a href="{{ route('projects.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>
            Back to Projects
        </a>
    </div>
    
    {{-- Project Description Card --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <h5 class="card-title fw-semibold mb-0">
                    <i class="bi bi-info-circle text-primary me-2"></i>
                    Project Description
                </h5>
                <span class="badge bg-light text-dark border">
                    <i class="bi bi-calendar me-1"></i>
                    Created {{ $project->created_at->format('M d, Y') }}
                </span>
            </div>
            <p class="card-text text-muted mb-0">
                {{ $project->description ?: 'No description provided.' }}
            </p>
        </div>
    </div>

    {{-- Project Stats --}}
    @if($project->tasks->count() > 0)
        <div class="row g-3 mb-4">
            <div class="col-md-3 col-sm-6">
                <div class="card border-0 bg-primary text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase small mb-1 opacity-75">Total Tasks</h6>
                                <h2 class="mb-0 fw-bold">{{ $project->tasks->count() }}</h2>
                            </div>
                            <i class="bi bi-list-task display-4 opacity-25"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card border-0 bg-success text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase small mb-1 opacity-75">Completed</h6>
                                <h2 class="mb-0 fw-bold">{{ $project->tasks->where('status', 'done')->count() }}</h2>
                            </div>
                            <i class="bi bi-check-circle display-4 opacity-25"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card border-0 bg-warning text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase small mb-1 opacity-75">In Progress</h6>
                                <h2 class="mb-0 fw-bold">{{ $project->tasks->where('status', 'in_progress')->count() }}</h2>
                            </div>
                            <i class="bi bi-arrow-repeat display-4 opacity-25"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card border-0 bg-secondary text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase small mb-1 opacity-75">Pending</h6>
                                <h2 class="mb-0 fw-bold">{{ $project->tasks->where('status', 'pending')->count() }}</h2>
                            </div>
                            <i class="bi bi-hourglass-split display-4 opacity-25"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Tasks Section Header --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold mb-0">
            <i class="bi bi-list-check text-primary me-2"></i>
            Tasks
        </h3>
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('projects.tasks.create', $project->id) }}" class="btn btn-success">
                <i class="bi bi-plus-circle me-2"></i>
                New Task
            </a>
            <button class="btn btn-outline-primary" 
                    type="button" 
                    data-bs-toggle="collapse" 
                    data-bs-target="#newTaskForm">
                <i class="bi bi-lightning-charge me-2"></i>
                Quick Add
            </button>
        </div>
    </div>

    {{-- Quick Add Task Form (Collapsible) --}}
    <div class="collapse mb-4" id="newTaskForm">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-primary text-white">
                <h6 class="mb-0">
                    <i class="bi bi-lightning-charge me-2"></i>
                    Quick Add Task
                </h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('projects.tasks.store', $project->id) }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="quick-title" class="form-label fw-semibold">Task Title *</label>
                            <input type="text" 
                                   name="title" 
                                   id="quick-title"
                                   class="form-control @error('title') is-invalid @enderror" 
                                   placeholder="Enter task title" 
                                   required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="quick-status" class="form-label fw-semibold">Status</label>
                            <select name="status" id="quick-status" class="form-select">
                                <option value="pending">Pending</option>
                                <option value="in_progress">In Progress</option>
                                <option value="done">Done</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="quick-priority" class="form-label fw-semibold">Priority</label>
                            <select name="priority" id="quick-priority" class="form-select">
                                <option value="low">Low</option>
                                <option value="medium" selected>Medium</option>
                                <option value="high">High</option>
                            </select>
                        </div>
                        <div class="col-md-9">
                            <label for="quick-description" class="form-label fw-semibold">Description</label>
                            <textarea name="description" 
                                      id="quick-description"
                                      class="form-control" 
                                      rows="2" 
                                      placeholder="Optional description"></textarea>
                        </div>
                        <div class="col-md-3">
                            <label for="quick-due-date" class="form-label fw-semibold">Due Date</label>
                            <input type="date" 
                                   name="due_date" 
                                   id="quick-due-date"
                                   class="form-control">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-2"></i>
                                Add Task
                            </button>
                            <button type="button" 
                                    class="btn btn-outline-secondary" 
                                    data-bs-toggle="collapse" 
                                    data-bs-target="#newTaskForm">
                                Cancel
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Tasks List --}}
    @forelse($project->tasks as $task)
        <x-task-card :task="$task" />
    @empty
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <i class="bi bi-inbox display-1 text-muted mb-3"></i>
                <h4 class="text-muted mb-3">No Tasks Yet</h4>
                <p class="text-muted mb-4">
                    Get started by creating your first task for this project
                </p>
                <div class="d-flex gap-2 justify-content-center">
                    <a href="{{ route('projects.tasks.create', $project->id) }}" 
                       class="btn btn-success">
                        <i class="bi bi-plus-circle me-2"></i>
                        Create First Task
                    </a>
                    <button class="btn btn-outline-primary" 
                            type="button" 
                            data-bs-toggle="collapse" 
                            data-bs-target="#newTaskForm">
                        <i class="bi bi-lightning-charge me-2"></i>
                        Quick Add
                    </button>
                </div>
            </div>
        </div>
    @endforelse

    {{-- Activity Log --}}
    @if($project->activities()->count() > 0)
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-header bg-light">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-activity text-primary me-2"></i>
                    Recent Activity
                </h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    @foreach($project->activities()->latest()->take(10)->get() as $activity)
                        <div class="list-group-item border-0 px-0 py-2">
                            <div class="d-flex gap-3">
                                <div class="flex-shrink-0">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" 
                                         style="width: 36px; height: 36px;">
                                        <i class="bi bi-person-fill"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-0">
                                        <strong>{{ $activity->user->name }}</strong> 
                                        <span class="text-muted">{{ str_replace('_', ' ', $activity->action) }}</span>
                                    </p>
                                    <small class="text-muted">
                                        <i class="bi bi-clock me-1"></i>
                                        {{ $activity->created_at->diffForHumans() }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
@endsection
