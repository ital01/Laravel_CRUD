<?php

use Illuminate\Http\Request;
use App\Http\Controllers\CrudController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [CrudController::class, 'index'])->middleware(['verified'])->name('dashboard');
    Route::get('/search', [CrudController::class, 'index'])->name('search');
    Route::post('/enviar-form', [CrudController::class, 'store'])->middleware(['verified']);
    Route::get('/dashboard/editar/{id}', [CrudController::class, 'edit'])->name('editar');
    Route::get('/dashboard/atualizar/{id}', [CrudController::class, 'update'])->name('atualizar');
    Route::delete('/dashboard/excluir/{id}', [CrudController::class, 'destroy'])->name('excluir');
    
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';