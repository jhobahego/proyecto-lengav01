<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::middleware('guest')->get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

$middlewareGroup = [
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
];

$middlewareGroupAdmin = [
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'role:MANAGER',
];

Route::middleware($middlewareGroup)->group(function () {
    Route::resource('/news', NewsController::class);
    Route::resource('/projects', ProjectController::class);
    Route::resource('/about', AboutController::class);
    Route::resource('/events', EventController::class);
});

Route::middleware($middlewareGroupAdmin)->group(function () {
    Route::resource('/admin', AdminController::class);
    Route::resource('/users', UserController::class);
});
