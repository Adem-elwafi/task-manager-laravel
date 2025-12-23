<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HealthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/health', [HealthController::class, 'index']);

// Temporary: make routes accessible without auth so you can test
Route::resource('projects', ProjectController::class);
Route::resource('projects.tasks', TaskController::class);

// Placeholder login route to avoid errors when middleware expects it
Route::get('/login', function () {
    return redirect('/');
})->name('login');
