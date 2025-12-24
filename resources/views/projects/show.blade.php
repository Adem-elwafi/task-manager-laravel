@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>{{ $project->name }}</h1>
            <a href="{{ route('projects.index') }}" class="btn btn-secondary">Back to Projects</a>
        </div>
        
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Description</h5>
                <p class="card-text">{{ $project->description ?? 'No description provided.' }}</p>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Tasks</h3>
            <div>
                <a href="{{ route('projects.tasks.create', $project->id) }}" class="btn btn-success btn-sm">New Task Page</a>
                <button class="btn btn-outline-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#newTaskForm" aria-expanded="false" aria-controls="newTaskForm">
                    Quick Add
                </button>
            </div>
        </div>

        <div class="collapse mb-3" id="newTaskForm">
            <div class="card card-body">
                <form method="POST" action="{{ route('projects.tasks.store', $project->id) }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-4">
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" placeholder="Task title" required>
                            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <select name="status" class="form-select">
                                <option value="pending">Pending</option>
                                <option value="in_progress">In Progress</option>
                                <option value="done">Done</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select name="priority" class="form-select">
                                <option value="low">Low</option>
                                <option value="medium" selected>Medium</option>
                                <option value="high">High</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <textarea name="description" class="form-control" rows="2" placeholder="Description (optional)"></textarea>
                        </div>
                        <div class="col-md-4">
                            <input type="date" name="due_date" class="form-control" placeholder="Due date (optional)">
                        </div>
                        <div class="col-md-8 text-end">
                            <button type="submit" class="btn btn-primary">Add Task</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <h4>Activity Log</h4>
        <ul class="list-group mb-3">
            @foreach($project->activities()->latest()->take(10)->get() as $activity)
                <li class="list-group-item">
                    {{ $activity->user->name }} {{ str_replace('_',' ', $activity->action) }}
                    on {{ $activity->created_at->format('M d, Y H:i') }}
                </li>
            @endforeach
        </ul>

        @forelse($project->tasks as $task)
            <x-task-card :task="$task" />
        @empty
            <div class="alert alert-info">
                No tasks yet. <a href="{{ route('projects.tasks.create', $project->id) }}">Create the first task</a>
            </div>
        @endforelse
    </div>
@endsection
