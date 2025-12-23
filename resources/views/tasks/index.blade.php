@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Tasks for: {{ $project->name }}</h1>
        <a href="{{ route('projects.tasks.create', $project->id) }}" class="btn btn-primary">New Task</a>
    </div>

    @forelse($tasks as $task)
        <x-task-card :task="$task" />
    @empty
        <div class="alert alert-info">No tasks yet.</div>
    @endforelse
</div>
@endsection