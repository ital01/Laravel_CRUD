<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CrudController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [CrudController::class, 'index'])
        ->middleware(['auth', 'verified'])
        ->name('dashboard');

    Route::get('/dashboard-search', [CrudController::class, 'searchByID'])
        ->middleware(['auth', 'verified'])
        ->name('dashboard.search');

    Route::post('/enviar-form', [CrudController::class, 'store']);

    Route::get('/dashboard/editar/{id}', [CrudController::class, 'edit'])
        ->name('editar');

    Route::post('/dashboard/atualizar/{id}', [CrudController::class, 'update'])
        ->name('atualizar');

    Route::delete('/dashboard/excluir/{id}', [CrudController::class, 'destroy'])
        ->name('excluir');

    Route::get('/search', [CrudController::class, 'search'])
        ->middleware(['auth', 'verified'])
        ->name('search');

    Route::get('/dashboard/usuarios-json', [CrudController::class, 'getUsersJson']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
