<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Task Manager') }}</title>

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
        
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            body {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .auth-card {
                max-width: 450px;
                width: 100%;
                border: none;
                border-radius: 1rem;
                box-shadow: 0 10px 40px rgba(0,0,0,.3);
            }
            .auth-header {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                border-radius: 1rem 1rem 0 0 !important;
                padding: 2rem;
                text-align: center;
            }
            .auth-logo {
                font-size: 3rem;
                margin-bottom: 1rem;
            }
            .btn-primary {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                border: none;
                padding: 0.75rem 2rem;
                font-weight: 600;
            }
            .btn-primary:hover {
                background: linear-gradient(135deg, #5568d3 0%, #6a3f8f 100%);
                transform: translateY(-1px);
                box-shadow: 0 4px 12px rgba(0,0,0,.2);
            }
            .form-control:focus {
                border-color: #667eea;
                box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25);
            }
            .back-link {
                position: absolute;
                top: 1rem;
                left: 1rem;
                color: white;
                text-decoration: none;
                font-weight: 500;
                padding: 0.5rem 1rem;
                background: rgba(255,255,255,0.2);
                border-radius: 0.5rem;
                transition: all 0.2s;
            }
            .back-link:hover {
                background: rgba(255,255,255,0.3);
                color: white;
            }
        </style>
    </head>
    <body>
        <a href="/" class="back-link">
            <i class="bi bi-arrow-left me-2"></i>
            Back to Home
        </a>
        
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card auth-card">
                        <div class="auth-header">
                            <div class="auth-logo">
                                <i class="bi bi-kanban"></i>
                            </div>
                            <h3 class="mb-0">Task Manager</h3>
                        </div>
                        <div class="card-body p-4">
                            {{ $slot }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
