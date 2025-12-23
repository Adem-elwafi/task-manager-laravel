@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">New Task for: {{ $project->name }}</h1>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('projects.tasks.store', $project->id) }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label" for="title">Title</label>
                    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="description">Description</label>
                    <textarea name="description" id="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label" for="status">Status</label>
                        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                            @foreach($statusOptions as $opt)
                                <option value="{{ $opt }}" @selected(old('status')===$opt)>{{ ucfirst(str_replace('_',' ', $opt)) }}</option>
                            @endforeach
                        </select>
                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label" for="priority">Priority</label>
                        <select name="priority" id="priority" class="form-select @error('priority') is-invalid @enderror">
                            @foreach($priorityOptions as $opt)
                                <option value="{{ $opt }}" @selected(old('priority')===$opt)>{{ ucfirst($opt) }}</option>
                            @endforeach
                        </select>
                        @error('priority')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label" for="due_date">Due Date</label>
                        <input type="date" name="due_date" id="due_date" class="form-control @error('due_date') is-invalid @enderror" value="{{ old('due_date') }}">
                        @error('due_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Create Task</button>
                <a href="{{ route('projects.show', $project->id) }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection