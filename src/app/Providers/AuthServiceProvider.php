<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Gate::dene('admin', function ($user) {
            return $user->role === 1;
        });
        Gate::dene('manager-higher', function ($user) {
            return $user->role > 0 && $user->role <= 5;
        });
        Gate::dene('user-higher', function ($user) {
            return $user->role > 0 && $user->role <= 9;
        });
    }
}
