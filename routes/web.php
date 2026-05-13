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
use App\Http\Controllers\CalendarController;
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

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | Search
    |--------------------------------------------------------------------------
    */

    Route::get('/search', [GlobalSearchController::class, 'index'])
        ->name('search.index');

    /*
    |--------------------------------------------------------------------------
    | Owner + Admin Only
    |--------------------------------------------------------------------------
    */

    Route::middleware(['role:owner|admin'])->group(function () {

        Route::resource('users', UserManagementController::class);

    });

    /*
    |--------------------------------------------------------------------------
    | Office Management
    |--------------------------------------------------------------------------
    */

    Route::middleware(['role:owner|admin|lawyer|trainee'])->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Clients
        |--------------------------------------------------------------------------
        */

        Route::resource('clients', ClientController::class);

        /*
        |--------------------------------------------------------------------------
        | Legal Cases
        |--------------------------------------------------------------------------
        */

        Route::resource('legal-cases', LegalCaseController::class);

        /*
        |--------------------------------------------------------------------------
        | Documents
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/legal-cases/{legalCase}/documents',
            [CaseDocumentController::class, 'store']
        )->name('legal-cases.documents.store');

        /*
        |--------------------------------------------------------------------------
        | Hearings
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/legal-cases/{legalCase}/hearings',
            [HearingController::class, 'store']
        );

        Route::delete('/hearings/{hearing}',[HearingController::class, 'destroy']);

        Route::post('/legal-cases/{legalCase}/tasks',[TaskController::class, 'store']);

        Route::delete('/tasks/{task}',[TaskController::class, 'destroy']);

        Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');

        Route::post('/notifications/{notification}/read',function ($notificationId) {
                auth()
                    ->user()
                    ->notifications()
                    ->where('id', $notificationId)
                    ->first()
                    ?->markAsRead();

                return back();
            }
        )->name('notifications.read');
    });

});
require __DIR__.'/auth.php';
