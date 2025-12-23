<div class="card mb-3 shadow-sm">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-start mb-2">
            <div class="flex-grow-1">
                <h5 class="card-title mb-1">{{ $task->title }}</h5>
                <p class="card-text text-muted">{{ $task->description ?? 'No description.' }}</p>
            </div>
            <div class="ms-2">
                <a href="{{ route('projects.tasks.edit', [$task->project_id, $task->id]) }}" class="btn btn-sm btn-warning text-white">Edit</a>
            </div>
        </div>
        
        <div class="mb-2">
            <span class="badge bg-info">{{ ucfirst(str_replace('_', ' ', $task->status)) }}</span>
            <span class="badge bg-warning">{{ ucfirst($task->priority) }}</span>
            @if($task->due_date)
                <span class="badge bg-dark">Due: {{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}</span>
            @endif
        </div>

        <form action="{{ route('projects.tasks.destroy', [$task->project_id, $task->id]) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger" data-confirm-delete>Delete</button>
        </form>
    </div>
</div>
