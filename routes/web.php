<?php

use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('todos.index');
});

Route::get('/dashboard', [TodoController::class, 'index'])->name('dashboard');

Route::get('/todos', [TodoController::class, 'index'])->name('todos.index');
Route::get('/todos/create', [TodoController::class, 'create'])->name('todos.create');
Route::post('/todos', [TodoController::class, 'store'])->name('todos.store');
Route::get('/todos/{todo}/edit', [TodoController::class, 'edit'])->name('todos.edit');
Route::put('/todos/{todo}', [TodoController::class, 'update'])->name('todos.update');
Route::delete('/todos/{todo}', [TodoController::class, 'destroy'])->name('todos.destroy');

// Additional routes for completed and pending todos
Route::get('/todos/completed', [TodoController::class, 'completed'])->name('todos.completed');
Route::get('/todos/pending', [TodoController::class, 'pending'])->name('todos.pending');

Route::patch('todos/{todo}/toggle', [TodoController::class, 'toggleComplete'])->name('todos.toggle');