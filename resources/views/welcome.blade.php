@extends('layouts.app')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    }
    
    .hero-section {
        padding: 6rem 0;
        background: 
            linear-gradient(135deg, rgba(102, 126, 234, 0.9) 0%, rgba(118, 75, 162, 0.9) 100%),
            repeating-linear-gradient(45deg, transparent, transparent 10px, rgba(255,255,255,.05) 10px, rgba(255,255,255,.05) 20px),
            linear-gradient(to bottom, #667eea, #764ba2);
        color: white;
        border-radius: 1.5rem;
        margin-bottom: 4rem;
        box-shadow: 0 20px 60px rgba(0,0,0,.3);
        position: relative;
        overflow: hidden;
    }
    
    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23ffffff" fill-opacity="0.05" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,112C672,96,768,96,864,112C960,128,1056,160,1152,165.3C1248,171,1344,149,1392,138.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>');
        background-size: cover;
        background-position: bottom;
        opacity: 0.3;
    }
    
    .hero-content {
        position: relative;
        z-index: 1;
    }
    
    .hero-title {
        font-size: 4rem;
        font-weight: 800;
        margin-bottom: 1.5rem;
        text-shadow: 3px 3px 6px rgba(0,0,0,.3);
        animation: fadeInUp 0.8s ease-out;
    }
    
    .hero-subtitle {
        font-size: 1.75rem;
        font-weight: 300;
        margin-bottom: 2.5rem;
        opacity: 0.95;
        text-shadow: 1px 1px 3px rgba(0,0,0,.2);
        animation: fadeInUp 1s ease-out;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .feature-card {
        height: 100%;
        border: none;
        background: white;
        border-radius: 1.25rem;
        padding: 2.5rem;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 6px rgba(0,0,0,.07);
    }
    
    .feature-card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 20px 40px rgba(0,0,0,.15);
        background: linear-gradient(135deg, #ffffff 0%, #f8f9ff 100%);
    }
    
    .feature-icon {
        font-size: 3.5rem;
        margin-bottom: 1.5rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        transition: transform 0.3s;
    }
    
    .feature-card:hover .feature-icon {
        transform: scale(1.1) rotate(5deg);
    }
    
    .cta-section {
        padding: 4rem 0;
        background: 
            linear-gradient(135deg, rgba(255,255,255,0.98) 0%, rgba(248,249,250,0.98) 100%),
            repeating-linear-gradient(90deg, transparent, transparent 20px, rgba(102, 126, 234, .03) 20px, rgba(102, 126, 234, .03) 40px),
            linear-gradient(to right, #f8f9fa, #e9ecef);
        border-radius: 1.5rem;
        margin-top: 4rem;
        box-shadow: 0 10px 40px rgba(0,0,0,.1);
        position: relative;
        overflow: hidden;
    }
    
    .cta-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, transparent 30%, rgba(102, 126, 234, 0.05) 100%);
    }
    
    .btn-glow {
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        transition: all 0.3s;
    }
    
    .btn-glow:hover {
        box-shadow: 0 6px 25px rgba(102, 126, 234, 0.6);
        transform: translateY(-2px);
    }
    
    .section-title {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    @media (max-width: 768px) {
        .hero-title {
            font-size: 2.75rem;
        }
        .hero-subtitle {
            font-size: 1.25rem;
        }
        .hero-section {
            padding: 4rem 0;
        }
    }
</style>

{{-- Hero Section --}}
<div class="hero-section text-center">
    <div class="container hero-content">
        <h1 class="hero-title">
            <i class="bi bi-kanban me-3"></i>
            Task Manager
        </h1>
        <p class="hero-subtitle">
            Organize your projects, track your tasks, and boost productivity
        </p>
        <div class="d-flex gap-3 justify-content-center flex-wrap">
            @guest
                <a href="{{ route('register') }}" class="btn btn-light btn-lg px-5 btn-glow">
                    <i class="bi bi-person-plus me-2"></i>
                    Get Started Free
                </a>
                <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg px-5">
                    <i class="bi bi-box-arrow-in-right me-2"></i>
                    Login
                </a>
            @else
                <a href="{{ route('projects.index') }}" class="btn btn-light btn-lg px-5 btn-glow">
                    <i class="bi bi-folder me-2"></i>
                    View My Projects
                </a>
                <a href="{{ route('projects.create') }}" class="btn btn-outline-light btn-lg px-5">
                    <i class="bi bi-plus-circle me-2"></i>
                    Create New Project
                </a>
            @endguest
        </div>
    </div>
</div>

{{-- Features Section --}}
<div class="container mb-5">
    <div class="text-center mb-5">
        <h2 class="display-5 fw-bold mb-3 section-title">Why Choose Task Manager?</h2>
        <p class="lead text-muted">Everything you need to manage your projects efficiently</p>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="feature-card">
                <div class="text-center">
                    <i class="bi bi-folder-plus feature-icon"></i>
                    <h3 class="h4 mb-3">Project Organization</h3>
                    <p class="text-muted">
                        Create and manage multiple projects with ease. Keep all your tasks organized in one place.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="feature-card">
                <div class="text-center">
                    <i class="bi bi-list-check feature-icon"></i>
                    <h3 class="h4 mb-3">Task Tracking</h3>
                    <p class="text-muted">
                        Track task status, priority, and deadlines. Filter and search to find what matters most.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="feature-card">
                <div class="text-center">
                    <i class="bi bi-chat-dots feature-icon"></i>
                    <h3 class="h4 mb-3">Collaboration</h3>
                    <p class="text-muted">
                        Add comments to tasks, track activity history, and collaborate with your team effectively.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="feature-card">
                <div class="text-center">
                    <i class="bi bi-funnel feature-icon"></i>
                    <h3 class="h4 mb-3">Smart Filters</h3>
                    <p class="text-muted">
                        Filter tasks by status, priority, or search terms. Find exactly what you need instantly.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="feature-card">
                <div class="text-center">
                    <i class="bi bi-shield-check feature-icon"></i>
                    <h3 class="h4 mb-3">Secure & Private</h3>
                    <p class="text-muted">
                        Your data is protected with enterprise-grade security. Only you can access your projects.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="feature-card">
                <div class="text-center">
                    <i class="bi bi-phone feature-icon"></i>
                    <h3 class="h4 mb-3">Responsive Design</h3>
                    <p class="text-muted">
                        Access your tasks anywhere, anytime. Fully responsive design works on all devices.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- CTA Section --}}
<div class="cta-section text-center">
    <div class="container" style="position: relative; z-index: 1;">
        <h2 class="display-6 fw-bold mb-3 section-title">Ready to Get Organized?</h2>
        <p class="lead text-muted mb-4">
            Join thousands of users managing their projects efficiently
        </p>
        @guest
            <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-5 btn-glow">
                <i class="bi bi-rocket-takeoff me-2"></i>
                Start Managing Tasks Now
            </a>
        @else
            <a href="{{ route('projects.index') }}" class="btn btn-primary btn-lg px-5 btn-glow">
                <i class="bi bi-arrow-right-circle me-2"></i>
                Go to Your Projects
            </a>
        @endguest
    </div>
</div>
@endsection
