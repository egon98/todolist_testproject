<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/todo', [TodoController::class, 'index'])->name('todo.index');
    Route::get('/todo/create', [TodoController::class, 'create'])->name('todo.create');
    Route::get('/todo/{id}/edit', [DashboardController::class, 'edit'])->name('dashboard.edit');
    Route::put('/todo/{id}', [DashboardController::class, 'update'])->name('dashboard.update');
    Route::delete('/todo/{id}', [DashboardController::class, 'destroy'])->name('dashboard.destroy');
    Route::post('/dashboard', [TodoController::class, 'store'])->name('todo.store');
    Route::post('/todo/update-status', [TodoController::class, 'updateStatus'])->name('todo.update-status');
    Route::post('/dashboard/filter', [DashboardController::class, 'filter'])->name('dashboard.filter');
    Route::post('/dashboard/filter/update-status', [DashboardController::class, 'updateStatus'])->name('dashboard.update-status');
});
