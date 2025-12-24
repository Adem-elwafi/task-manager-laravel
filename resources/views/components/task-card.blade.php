<div class="card mb-3 shadow-sm border-0">
    {{-- Card Header with Title --}}
    <div class="card-header bg-white border-0 pt-3 pb-2">
        <div class="d-flex justify-content-between align-items-start">
            <div class="flex-grow-1">
                <h5 class="card-title mb-1 fw-bold">
                    @if($task->status === 'done')
                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                    @elseif($task->status === 'in_progress')
                        <i class="bi bi-arrow-repeat text-primary me-2"></i>
                    @else
                        <i class="bi bi-circle text-secondary me-2"></i>
                    @endif
                    {{ $task->title }}
                </h5>
            </div>
            @can('update', $task)
                <div class="ms-3">
                    <a href="{{ route('projects.tasks.edit', [$task->project_id, $task->id]) }}" 
                       class="btn btn-sm btn-outline-primary" 
                       title="Edit Task">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                </div>
            @endcan
        </div>
    </div>
    
    {{-- Card Body --}}
    <div class="card-body pt-2">
        {{-- Description --}}
        @if($task->description)
            <p class="card-text text-muted mb-3">
                <i class="bi bi-text-paragraph me-2"></i>
                {{ $task->description }}
            </p>
        @else
            <p class="card-text text-muted fst-italic mb-3">
                <i class="bi bi-text-paragraph me-2"></i>
                No description provided.
            </p>
        @endif
        
        {{-- Badges --}}
        <div class="mb-3 d-flex flex-wrap gap-2 align-items-center">
            {{-- Status Badge --}}
            @php
                $statusColors = [
                    'pending' => 'bg-secondary',
                    'in_progress' => 'bg-primary',
                    'done' => 'bg-success'
                ];
                $statusIcons = [
                    'pending' => 'bi-hourglass-split',
                    'in_progress' => 'bi-arrow-repeat',
                    'done' => 'bi-check-circle'
                ];
                $statusColor = $statusColors[$task->status] ?? 'bg-secondary';
                $statusIcon = $statusIcons[$task->status] ?? 'bi-circle';
            @endphp
            <span class="badge {{ $statusColor }}">
                <i class="bi {{ $statusIcon }} me-1"></i>
                {{ ucfirst(str_replace('_', ' ', $task->status)) }}
            </span>
            
            {{-- Priority Badge --}}
            @php
                $priorityColors = [
                    'low' => 'bg-info',
                    'medium' => 'bg-warning text-dark',
                    'high' => 'bg-danger'
                ];
                $priorityIcons = [
                    'low' => 'bi-arrow-down',
                    'medium' => 'bi-dash',
                    'high' => 'bi-arrow-up'
                ];
                $priorityColor = $priorityColors[$task->priority] ?? 'bg-secondary';
                $priorityIcon = $priorityIcons[$task->priority] ?? 'bi-dash';
            @endphp
            <span class="badge {{ $priorityColor }}">
                <i class="bi {{ $priorityIcon }} me-1"></i>
                {{ ucfirst($task->priority) }} Priority
            </span>
            
            {{-- Due Date Badge --}}
            @if($task->due_date)
                @php
                    $dueDate = \Carbon\Carbon::parse($task->due_date);
                    $isOverdue = $dueDate->isPast() && $task->status !== 'done';
                    $dueDateColor = $isOverdue ? 'bg-danger' : 'bg-dark';
                @endphp
                <span class="badge {{ $dueDateColor }}">
                    <i class="bi bi-calendar-event me-1"></i>
                    @if($isOverdue)
                        Overdue: 
                    @else
                        Due: 
                    @endif
                    {{ $dueDate->format('M d, Y') }}
                </span>
            @endif

            {{-- Assignee Badge --}}
            @if($task->user)
                <span class="badge bg-light text-dark border">
                    <i class="bi bi-person me-1"></i>
                    {{ $task->user->name }}
                </span>
            @endif
        </div>

        {{-- Action Buttons --}}
        <div class="d-flex gap-2 align-items-center">
            @can('delete', $task)
                <form action="{{ route('projects.tasks.destroy', [$task->project_id, $task->id]) }}" 
                      method="POST" 
                      class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="btn btn-sm btn-outline-danger" 
                            data-confirm-delete
                            title="Delete Task">
                        <i class="bi bi-trash"></i> Delete
                    </button>
                </form>
            @endcan

            {{-- Comments Count --}}
            @if($task->comments->count() > 0)
                <span class="text-muted small ms-auto">
                    <i class="bi bi-chat-dots"></i>
                    {{ $task->comments->count() }} 
                    {{ Str::plural('comment', $task->comments->count()) }}
                </span>
            @endif
        </div>
    </div>

    {{-- Comments Section (Collapsible) --}}
    @if($task->comments->count() > 0 || auth()->check())
        <div class="card-footer bg-light border-0">
            <div class="accordion accordion-flush" id="comments-{{ $task->id }}">
                <div class="accordion-item bg-transparent border-0">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-transparent shadow-none p-0 fw-semibold" 
                                type="button" 
                                data-bs-toggle="collapse" 
                                data-bs-target="#comments-body-{{ $task->id }}">
                            <i class="bi bi-chat-left-text me-2"></i>
                            Comments ({{ $task->comments->count() }})
                        </button>
                    </h2>
                    <div id="comments-body-{{ $task->id }}" 
                         class="accordion-collapse collapse" 
                         data-bs-parent="#comments-{{ $task->id }}">
                        <div class="accordion-body px-0 pt-3">
                            {{-- Comments List --}}
                            @if($task->comments->count() > 0)
                                <div class="list-group list-group-flush mb-3">
                                    @foreach($task->comments as $comment)
                                        <div class="list-group-item border-0 px-0 py-2">
                                            <div class="d-flex gap-2">
                                                <div class="flex-shrink-0">
                                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" 
                                                         style="width: 32px; height: 32px;">
                                                        <i class="bi bi-person-fill"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="d-flex justify-content-between align-items-start">
                                                        <strong class="small">{{ $comment->user->name }}</strong>
                                                        <span class="text-muted small">
                                                            {{ $comment->created_at->diffForHumans() }}
                                                        </span>
                                                    </div>
                                                    <p class="mb-0 text-muted small mt-1">{{ $comment->body }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            {{-- Add Comment Form --}}
                            @auth
                                <form action="{{ route('projects.tasks.comments.store', [$task->project_id, $task->id]) }}" 
                                      method="POST">
                                    @csrf
                                    <div class="input-group">
                                        <input type="text" 
                                               name="body" 
                                               class="form-control" 
                                               placeholder="Add a comment..." 
                                               required>
                                        <button class="btn btn-primary" type="submit">
                                            <i class="bi bi-send"></i> Post
                                        </button>
                                    </div>
                                </form>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
