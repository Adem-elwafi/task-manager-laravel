@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Projects</h1>
        <a href="{{ route('projects.create') }}" class="btn btn-primary mb-3">Create New Project</a>
        
        <div class="row">
            @forelse($projects as $project)
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $project->name }}</h5>
                            <p class="card-text">{{ $project->description }}</p>
                            <a href="{{ route('projects.show', $project->id) }}" class="btn btn-sm btn-primary">View</a>
                        </div>
                    </div>
                </div>
            @empty
                <p>No projects found.</p>
            @endforelse
        </div>
    </div>
@endsection
