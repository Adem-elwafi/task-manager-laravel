<div class="card mb-2">
    <div class="card-body">
        <h5 class="card-title">{{ $task->title }}</h5>
        <p class="card-text">{{ $task->description }}</p>
        <span class="badge bg-info">{{ $task->status }}</span>
        <span class="badge bg-warning">{{ $task->priority }}</span>
        @if($task->due_date)
            <span class="badge bg-dark">Due: {{ $task->due_date }}</span>
        @endif
    </div>
</div>
