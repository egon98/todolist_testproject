<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/todo/create', [TodoController::class, 'create'])->name('todo.create');
    Route::get('/todo/{id}/edit', [TodoController::class, 'edit'])->name('todo.edit');
    Route::put('/todo/{id}', [TodoController::class, 'update'])->name('todo.update');
    Route::delete('/todo/{id}', [TodoController::class, 'destroy'])->name('todo.destroy');
    Route::post('/dashboard', [TodoController::class, 'store'])->name('todo.store');
    Route::post('/todo/update-status', [TodoController::class, 'updateStatus'])->name('todo.update-status');
    Route::post('/todo/filter', [TodoController::class, 'filter'])->name('todo.filter');
    Route::post('/todo/filter/update-status', [TodoController::class, 'updateStatus'])->name('todo.update-status');
});
