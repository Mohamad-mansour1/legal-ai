<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\LegalCaseController;
use App\Http\Controllers\CaseDocumentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\HearingController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\GlobalSearchController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
    Route::resource('users', UserManagementController::class);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('clients', ClientController::class);
    Route::resource('legal-cases', LegalCaseController::class);

    Route::post('/legal-cases/{legalCase}/documents', [CaseDocumentController::class, 'store'])
        ->name('legal-cases.documents.store');

    Route::post('/legal-cases/{legalCase}/hearings', [HearingController::class, 'store']);
    Route::delete('/hearings/{hearing}',[HearingController::class, 'destroy']);

    Route::post('/legal-cases/{legalCase}/tasks',[TaskController::class, 'store']);
    Route::delete('/tasks/{task}',[TaskController::class, 'destroy']);


    Route::get('/search', [GlobalSearchController::class, 'index'])->name('search.index');
});

require __DIR__.'/auth.php';
