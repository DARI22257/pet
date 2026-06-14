<?php

namespace App\Providers;

use App\Models\AdoptionApplication;
use App\Policies\AdoptionApplicationPolicy;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        AdoptionApplication::class => AdoptionApplicationPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Gates для разграничения прав
        Gate::define('be-volunteer', function ($user) {
            return in_array($user->role, ['admin', 'volunteer']);
        });

        Gate::define('manage-pets', function ($user) {
            return in_array($user->role, ['admin', 'volunteer']);
        });

        Gate::define('access-admin-panel', function ($user) {
            return $user->role === 'admin';
        });
        
        Gate::define('view-applications', function ($user) {
            return in_array($user->role, ['admin', 'volunteer']);
        });
    }
}