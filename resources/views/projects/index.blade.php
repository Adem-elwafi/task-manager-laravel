@extends('layouts.app')

@section('content')
    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="display-5 fw-bold mb-2">
                <i class="bi bi-folder text-primary"></i>
                My Projects
            </h1>
            <p class="text-muted mb-0">Manage all your projects in one place</p>
        </div>
        <a href="{{ route('projects.create') }}" class="btn btn-primary btn-lg">
            <i class="bi bi-plus-circle me-2"></i>
            New Project
        </a>
    </div>

    {{-- Projects Grid --}}
    @forelse($projects as $project)
        <div class="row g-4">
            @foreach($projects as $project)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <h5 class="card-title fw-bold mb-0">
                                    <i class="bi bi-folder-fill text-primary me-2"></i>
                                    {{ $project->name }}
                                </h5>
                                @if($project->tasks_count ?? $project->tasks->count() ?? 0)
                                    <span class="badge bg-primary rounded-pill">
                                        {{ $project->tasks_count ?? $project->tasks->count() }}
                                    </span>
                                @endif
                            </div>
                            
                            <p class="card-text text-muted flex-grow-1">
                                {{ Str::limit($project->description ?? 'No description provided.', 120) }}
                            </p>

                            {{-- Project Stats --}}
                            @if(isset($project->tasks) && $project->tasks->count() > 0)
                                <div class="mb-3">
                                    <small class="text-muted d-block mb-2">
                                        <i class="bi bi-bar-chart-fill me-1"></i>
                                        Progress:
                                    </small>
                                    @php
                                        $total = $project->tasks->count();
                                        $done = $project->tasks->where('status', 'done')->count();
                                        $progress = $total > 0 ? round(($done / $total) * 100) : 0;
                                    @endphp
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar bg-success" 
                                             role="progressbar" 
                                             style="width: {{ $progress }}%"
                                             aria-valuenow="{{ $progress }}" 
                                             aria-valuemin="0" 
                                             aria-valuemax="100">
                                        </div>
                                    </div>
                                    <small class="text-muted">{{ $done }} of {{ $total }} tasks completed</small>
                                </div>
                            @endif

                            {{-- Action Button --}}
                            <div class="mt-auto">
                                <a href="{{ route('projects.show', $project->id) }}" 
                                   class="btn btn-primary w-100">
                                    <i class="bi bi-eye me-2"></i>
                                    View Project
                                </a>
                            </div>
                        </div>
                        
                        {{-- Card Footer with Metadata --}}
                        <div class="card-footer bg-light border-0 text-muted small">
                            <i class="bi bi-calendar me-1"></i>
                            Created {{ $project->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @empty
        <div class="text-center py-5">
            <div class="mb-4">
                <i class="bi bi-folder-x display-1 text-muted"></i>
            </div>
            <h3 class="text-muted mb-3">No Projects Yet</h3>
            <p class="text-muted mb-4">Get started by creating your first project</p>
            <a href="{{ route('projects.create') }}" class="btn btn-primary btn-lg">
                <i class="bi bi-plus-circle me-2"></i>
                Create Your First Project
            </a>
        </div>
    @endforelse
@endsection
