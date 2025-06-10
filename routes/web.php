<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;

// Test de deploy automático

Route::get('/', function () {
    return redirect()->route('todos.index');
});

Route::get('/todos', [TodoController::class, 'index'])->name('todos.index');
Route::post('/todos', [TodoController::class, 'store'])->name('todos.store');
Route::patch('/todos/{id}', [TodoController::class, 'update'])->name('todos.update');
Route::delete('/todos/{id}', [TodoController::class, 'destroy'])->name('todos.destroy');