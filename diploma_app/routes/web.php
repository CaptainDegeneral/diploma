<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('admin', function () {
    return Inertia::render('Administration');
})->middleware(['auth', 'verified', 'admin'])->name('admin');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    /**
     * Эндпоинты для CRUD-операций с дисциплинами
     */
    Route::controller(SubjectController::class)
        ->name('subject.')
        ->prefix('subjects')
        ->group(function () {
       Route::get('/', 'index')->name('index');

       Route::middleware(['admin'])->group(function () {
           Route::get('{subject}', 'show')->name('show');
           Route::post('/', 'store')->name('store');
           Route::put('{subject}', 'edit')->name('edit');
           Route::delete('{subject}', 'destroy')->name('destroy');
       });
    });

    /**
     * Эндпоинты для CRUD-операций с пользователями
     */
    Route::controller(UserController::class)
        ->middleware(['admin'])
        ->name('user.')
        ->prefix('users')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('{user}', 'show')->name('show');
            Route::post('/', 'store')->name('store');
            Route::put('{user}', 'edit')->name('edit');
            Route::delete('{user}', 'destroy')->name('destroy');
        });

    Route::controller(ReportController::class)
        ->name('report.')
        ->prefix('reports')
        ->group(function () {
            Route::get('/', 'index',)->name('index');
            Route::get('{report}', 'show')->name('show');
            Route::post('/', 'store')->name('store');
            Route::put('{report}', 'edit')->name('edit');
            Route::delete('{report}', 'destroy')->name('destroy');
        });
});

require __DIR__.'/auth.php';
