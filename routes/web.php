<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HealthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/health', [HealthController::class, 'index']);


Route::resource('projects', App\Http\Controllers\ProjectController::class);
Route::resource('projects.tasks', TaskController::class);
