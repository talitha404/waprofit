<?php

use App\Http\Controllers\CalculatorController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TemplateController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route default dari Laravel Breeze
Route::get('/', function () {
    return view('auth.register');
});

Route::get('/dashboard', function () {
    if (Auth::check() && Auth::user()?->role?->name === 'admin') {
        return view('dashboard-admin');
    }

    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Grup utama untuk semua route yang memerlukan otentikasi
Route::middleware('auth')->group(function () {
    Route::get('/calculator', [CalculatorController::class, 'index'])->name('calculator.index');
    Route::post('/calculator/history', [CalculatorController::class, 'store'])->name('calculator.store');
    Route::post('/calculator/pdf', [CalculatorController::class, 'pdf'])->name('calculator.pdf');
    // Route untuk profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- Grup untuk Admin ---
    // Hanya user dengan role 'admin' yang bisa mengakses route di dalam grup ini.
    Route::middleware('role:admin')->name('admin.')->prefix('admin')->group(function () {
        Route::get('/dashboard', function () {
            return '<h1>Admin Dashboard</h1>'; // Placeholder
        })->name('dashboard');

        // CRUD untuk Templates
        Route::resource('templates', TemplateController::class);
    });

    // --- Grup untuk Staff ---
    // Hanya user dengan role 'staff' yang bisa mengakses route di dalam grup ini.
    Route::middleware('role:staff')->name('staff.')->prefix('staff')->group(function () {
        Route::get('/dashboard', function () {
            return '<h1>Staff Dashboard</h1>'; // Placeholder
        })->name('dashboard');

        // CRUD untuk Documents
        Route::resource('documents', DocumentController::class);
    });
});

require __DIR__.'/auth.php';
