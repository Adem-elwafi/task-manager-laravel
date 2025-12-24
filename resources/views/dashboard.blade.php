@extends('layouts.app')

@section('content')
    {{-- Welcome Header --}}
    <div class="mb-5 text-center">
        <h1 class="display-4 fw-bold mb-3">
            <i class="bi bi-speedometer2 text-primary me-3"></i>
            Welcome back, {{ Auth::user()->name }}!
        </h1>
        <p class="lead text-muted">Here's an overview of your projects and tasks</p>
    </div>

    {{-- Quick Stats Cards --}}
    <div class="row g-4 mb-5">
        @php
            $projects = Auth::user()->projects ?? collect();
            $allTasks = $projects->flatMap->tasks ?? collect();
            $totalProjects = $projects->count();
            $totalTasks = $allTasks->count();
            $completedTasks = $allTasks->where('status', 'done')->count();
            $pendingTasks = $allTasks->where('status', 'pending')->count();
            $inProgressTasks = $allTasks->where('status', 'in_progress')->count();
        @endphp

        <div class="col-md-3 col-sm-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase text-muted small mb-2">Total Projects</h6>
                            <h2 class="mb-0 fw-bold text-primary">{{ $totalProjects }}</h2>
                        </div>
                        <div class="bg-primary bg-opacity-10 rounded-3 p-3">
                            <i class="bi bi-folder-fill text-primary" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a href="{{ route('projects.index') }}" class="text-decoration-none small">
                        View all projects <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase text-muted small mb-2">Total Tasks</h6>
                            <h2 class="mb-0 fw-bold text-info">{{ $totalTasks }}</h2>
                        </div>
                        <div class="bg-info bg-opacity-10 rounded-3 p-3">
                            <i class="bi bi-list-task text-info" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <small class="text-muted">Across all projects</small>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase text-muted small mb-2">Completed</h6>
                            <h2 class="mb-0 fw-bold text-success">{{ $completedTasks }}</h2>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded-3 p-3">
                            <i class="bi bi-check-circle-fill text-success" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0">
                    @if($totalTasks > 0)
                        <small class="text-muted">{{ round(($completedTasks / $totalTasks) * 100) }}% completion rate</small>
                    @else
                        <small class="text-muted">No tasks yet</small>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase text-muted small mb-2">In Progress</h6>
                            <h2 class="mb-0 fw-bold text-warning">{{ $inProgressTasks }}</h2>
                        </div>
                        <div class="bg-warning bg-opacity-10 rounded-3 p-3">
                            <i class="bi bi-arrow-repeat text-warning" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <small class="text-muted">{{ $pendingTasks }} pending tasks</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="row g-4 mb-5">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h5 class="mb-0">
                        <i class="bi bi-lightning-charge me-2"></i>
                        Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('projects.create') }}" class="btn btn-outline-primary btn-lg text-start">
                            <i class="bi bi-plus-circle me-2"></i>
                            Create New Project
                        </a>
                        @if($totalProjects > 0)
                            <a href="{{ route('projects.index') }}" class="btn btn-outline-success btn-lg text-start">
                                <i class="bi bi-folder-open me-2"></i>
                                Browse All Projects
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="bi bi-bar-chart me-2"></i>
                        Your Progress
                    </h5>
                </div>
                <div class="card-body">
                    @if($totalTasks > 0)
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Overall Completion</span>
                                <span class="fw-bold">{{ round(($completedTasks / $totalTasks) * 100) }}%</span>
                            </div>
                            <div class="progress" style="height: 20px;">
                                <div class="progress-bar bg-success" 
                                     role="progressbar" 
                                     style="width: {{ ($completedTasks / $totalTasks) * 100 }}%">
                                </div>
                            </div>
                        </div>
                        <div class="row text-center small">
                            <div class="col-4">
                                <div class="p-2 bg-light rounded">
                                    <i class="bi bi-hourglass-split text-secondary d-block mb-1"></i>
                                    <strong>{{ $pendingTasks }}</strong>
                                    <div class="text-muted">Pending</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="p-2 bg-light rounded">
                                    <i class="bi bi-arrow-repeat text-warning d-block mb-1"></i>
                                    <strong>{{ $inProgressTasks }}</strong>
                                    <div class="text-muted">In Progress</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="p-2 bg-light rounded">
                                    <i class="bi bi-check-circle text-success d-block mb-1"></i>
                                    <strong>{{ $completedTasks }}</strong>
                                    <div class="text-muted">Done</div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-3">
                            <i class="bi bi-inbox display-4 text-muted mb-3"></i>
                            <p class="text-muted">No tasks yet. Create a project to get started!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Projects --}}
    @if($totalProjects > 0)
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-clock-history text-primary me-2"></i>
                        Recent Projects
                    </h5>
                    <a href="{{ route('projects.index') }}" class="btn btn-sm btn-outline-primary">
                        View All
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    @foreach($projects->take(3) as $project)
                        <div class="col-md-4">
                            <div class="card border h-100">
                                <div class="card-body">
                                    <h6 class="card-title fw-bold">
                                        <i class="bi bi-folder-fill text-primary me-2"></i>
                                        {{ $project->name }}
                                    </h6>
                                    <p class="card-text text-muted small">
                                        {{ Str::limit($project->description ?? 'No description', 80) }}
                                    </p>
                                    @if($project->tasks->count() > 0)
                                        @php
                                            $projectTotal = $project->tasks->count();
                                            $projectDone = $project->tasks->where('status', 'done')->count();
                                            $projectProgress = round(($projectDone / $projectTotal) * 100);
                                        @endphp
                                        <div class="mb-2">
                                            <small class="text-muted">{{ $projectDone }}/{{ $projectTotal }} tasks</small>
                                            <div class="progress" style="height: 5px;">
                                                <div class="progress-bar bg-success" 
                                                     style="width: {{ $projectProgress }}%"></div>
                                            </div>
                                        </div>
                                    @endif
                                    <a href="{{ route('projects.show', $project->id) }}" 
                                       class="btn btn-sm btn-outline-primary w-100">
                                        <i class="bi bi-eye me-1"></i>
                                        View Project
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @else
        {{-- Empty State --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <i class="bi bi-folder-x display-1 text-muted mb-4"></i>
                <h3 class="mb-3">Welcome to Task Manager!</h3>
                <p class="text-muted mb-4 lead">
                    You haven't created any projects yet. Get started by creating your first project.
                </p>
                <a href="{{ route('projects.create') }}" class="btn btn-primary btn-lg">
                    <i class="bi bi-plus-circle me-2"></i>
                    Create Your First Project
                </a>
            </div>
        </div>
    @endif
@endsection
