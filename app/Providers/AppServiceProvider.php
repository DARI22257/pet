<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Gate::define('admin', function ($user) {
            return $user->role === 'admin';
        });

        Gate::define('volunteer', function ($user) {
            return in_array($user->role, ['admin', 'volunteer']);
        });

        Gate::define('manage-pets', function ($user) {
            return in_array($user->role, ['admin', 'volunteer']);
        });

        Gate::define('access-admin-panel', function ($user) {
            return $user->role === 'admin';
        });
    }
}
