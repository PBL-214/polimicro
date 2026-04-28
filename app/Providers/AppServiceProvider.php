<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        View::composer('layouts.dashboard', function ($view) {
            if (auth()->check()) {
                $view->with('notifications', auth()->user()->unreadNotifications->take(10));
                $view->with('unreadCount', auth()->user()->unreadNotifications->count());
            }
        });
    }
}
