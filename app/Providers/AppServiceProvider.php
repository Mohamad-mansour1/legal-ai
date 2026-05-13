<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Inertia::share([

            'notifications' => function () {

                if (! Auth::check()) {
                    return [];
                }

                return Auth::user()
                    ->unreadNotifications
                    
                    ->take(10)
                    ->map(function ($notification) {

                        return [
                            'id' => $notification->id,
                            'title' => $notification->data['title'] ?? '',
                            'message' => $notification->data['message'] ?? '',
                            'created_at' => $notification->created_at
                                ->diffForHumans(),
                        ];
                    });

            },

        ]);
        Vite::prefetch(concurrency: 3);
    }
}
