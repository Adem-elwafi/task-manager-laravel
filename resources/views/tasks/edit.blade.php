@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            {{-- Page Header --}}
            <div class="mb-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('projects.index') }}" class="text-decoration-none">
                                <i class="bi bi-folder"></i> Projects
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('projects.show', $project->id) }}" class="text-decoration-none">
                                {{ $project->name }}
                            </a>
                        </li>
                        <li class="breadcrumb-item active">Edit Task</li>
                    </ol>
                </nav>
                
                <h1 class="display-6 fw-bold mb-2">
                    <i class="bi bi-pencil-square text-primary"></i>
                    Edit Task
                </h1>
                <p class="text-muted">Update task details for <strong>{{ $project->name }}</strong></p>
            </div>

            {{-- Validation Errors --}}
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                    <h5 class="alert-heading">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        Please fix the following errors:
                    </h5>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Form Card --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-card-text me-2"></i>
                        Task: {{ $task->title }}
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('projects.tasks.update', [$project->id, $task->id]) }}">
                        @csrf
                        @method('PUT')

                        {{-- Title --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold" for="title">
                                <i class="bi bi-card-text me-2"></i>
                                Task Title <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   name="title" 
                                   id="title" 
                                   class="form-control form-control-lg @error('title') is-invalid @enderror" 
                                   value="{{ old('title', $task->title) }}" 
                                   placeholder="Enter a descriptive title for this task"
                                   required
                                   autofocus>
                            @error('title')
                                <div class="invalid-feedback">
                                    <i class="bi bi-exclamation-circle me-1"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold" for="description">
                                <i class="bi bi-text-paragraph me-2"></i>
                                Description
                            </label>
                            <textarea name="description" 
                                      id="description" 
                                      rows="5" 
                                      class="form-control @error('description') is-invalid @enderror"
                                      placeholder="Add detailed information about this task...">{{ old('description', $task->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">
                                    <i class="bi bi-exclamation-circle me-1"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Status, Priority, Due Date Row --}}
                        <div class="row">
                            {{-- Status --}}
                            <div class="col-md-4 mb-4">
                                <label class="form-label fw-semibold" for="status">
                                    <i class="bi bi-hourglass-split me-2"></i>
                                    Status <span class="text-danger">*</span>
                                </label>
                                <select name="status" 
                                        id="status" 
                                        class="form-select @error('status') is-invalid @enderror"
                                        required>
                                    @foreach($statusOptions as $opt)
                                        <option value="{{ $opt }}" @selected(old('status', $task->status)===$opt)>
                                            {{ ucfirst(str_replace('_',' ', $opt)) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Priority --}}
                            <div class="col-md-4 mb-4">
                                <label class="form-label fw-semibold" for="priority">
                                    <i class="bi bi-exclamation-triangle me-2"></i>
                                    Priority <span class="text-danger">*</span>
                                </label>
                                <select name="priority" 
                                        id="priority" 
                                        class="form-select @error('priority') is-invalid @enderror"
                                        required>
                                    @foreach($priorityOptions as $opt)
                                        <option value="{{ $opt }}" @selected(old('priority', $task->priority)===$opt)>
                                            {{ ucfirst($opt) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('priority')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Due Date --}}
                            <div class="col-md-4 mb-4">
                                <label class="form-label fw-semibold" for="due_date">
                                    <i class="bi bi-calendar-event me-2"></i>
                                    Due Date
                                </label>
                                <input type="date" 
                                       name="due_date" 
                                       id="due_date" 
                                       class="form-control @error('due_date') is-invalid @enderror" 
                                       value="{{ old('due_date', $task->due_date) }}">
                                @error('due_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="d-flex gap-3 justify-content-end pt-3 border-top">
                            <a href="{{ route('projects.show', $project->id) }}" 
                               class="btn btn-lg btn-outline-secondary">
                                <i class="bi bi-x-circle me-2"></i>
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-lg btn-primary">
                                <i class="bi bi-check-circle me-2"></i>
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Task Info Card --}}
            <div class="card border-0 bg-light mt-4">
                <div class="card-body">
                    <h6 class="fw-semibold mb-2">
                        <i class="bi bi-info-circle text-primary me-2"></i>
                        Task Information
                    </h6>
                    <div class="row small text-muted">
                        <div class="col-md-6">
                            <p class="mb-1">
                                <i class="bi bi-calendar-plus me-2"></i>
                                <strong>Created:</strong> {{ $task->created_at->format('M d, Y') }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1">
                                <i class="bi bi-clock-history me-2"></i>
                                <strong>Last Updated:</strong> {{ $task->updated_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection