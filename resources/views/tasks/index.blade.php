@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Tasks for: {{ $project->name }}</h1>
        @can('create', [App\Models\Task::class, $project])
            <a href="{{ route('projects.tasks.create', $project->id) }}" class="btn btn-primary">New Task</a>
        @endcan
    </div>

    <form method="GET" class="row g-3 mb-3">
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">-- Status --</option>
                <option value="pending" {{ request('status')=='pending' ? 'selected' : '' }}>Pending</option>
                <option value="in_progress" {{ request('status')=='in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="done" {{ request('status')=='done' ? 'selected' : '' }}>Done</option>
            </select>
        </div>
        <div class="col-md-3">
            <select name="priority" class="form-select">
                <option value="">-- Priority --</option>
                <option value="low" {{ request('priority')=='low' ? 'selected' : '' }}>Low</option>
                <option value="medium" {{ request('priority')=='medium' ? 'selected' : '' }}>Medium</option>
                <option value="high" {{ request('priority')=='high' ? 'selected' : '' }}>High</option>
            </select>
        </div>
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Search tasks..." value="{{ request('search') }}">
        </div>
        <div class="col-md-2 d-grid">
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
    </form>

    @forelse($tasks as $task)
        <x-task-card :task="$task" />
    @empty
        <div class="alert alert-info">No tasks found for your filters.</div>
    @endforelse

    <div class="mt-3">
        {{ $tasks->links() }}
    </div>
</div>
@endsection