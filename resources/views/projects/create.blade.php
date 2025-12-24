@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            {{-- Page Header --}}
            <div class="mb-4">
                <h1 class="display-6 fw-bold mb-2">
                    <i class="bi bi-plus-circle text-primary"></i>
                    Create New Project
                </h1>
                <p class="text-muted">Start organizing your tasks with a new project</p>
            </div>
            
            {{-- Form Card --}}
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('projects.store') }}" method="POST">
                        @csrf
                        
                        {{-- Project Name --}}
                        <div class="mb-4">
                            <label for="name" class="form-label fw-semibold">
                                <i class="bi bi-folder me-2"></i>
                                Project Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control form-control-lg @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   placeholder="Enter project name (e.g., Website Redesign)"
                                   required 
                                   autofocus>
                            @error('name')
                                <div class="invalid-feedback">
                                    <i class="bi bi-exclamation-circle me-1"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                            <small class="form-text text-muted">
                                Choose a clear, descriptive name for your project
                            </small>
                        </div>
                        
                        {{-- Description --}}
                        <div class="mb-4">
                            <label for="description" class="form-label fw-semibold">
                                <i class="bi bi-text-paragraph me-2"></i>
                                Description
                            </label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="5"
                                      placeholder="Describe the goals and scope of this project...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">
                                    <i class="bi bi-exclamation-circle me-1"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                            <small class="form-text text-muted">
                                Optional: Add details about what this project aims to achieve
                            </small>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="d-flex gap-3 justify-content-end pt-3 border-top">
                            <a href="{{ route('projects.index') }}" class="btn btn-lg btn-outline-secondary">
                                <i class="bi bi-x-circle me-2"></i>
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-lg btn-primary">
                                <i class="bi bi-check-circle me-2"></i>
                                Create Project
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Help Card --}}
            <div class="card border-0 bg-light mt-4">
                <div class="card-body">
                    <h6 class="fw-semibold mb-2">
                        <i class="bi bi-lightbulb text-warning me-2"></i>
                        Quick Tips
                    </h6>
                    <ul class="small text-muted mb-0">
                        <li>Keep project names concise and meaningful</li>
                        <li>Use the description to outline key objectives</li>
                        <li>You can add tasks to your project after creating it</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
