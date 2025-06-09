<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        // Model policies here
    ];

    public function boot()
    {
        $this->registerPolicies();

        // Define role-based gates
        Gate::define('superadmin', function (User $user) {
            return $user->role === 'superadmin';
        });

        Gate::define('admin', function (User $user) {
            return $user->role === 'admin';
        });

        Gate::define('teacher', function (User $user) {
            return $user->role === 'teacher';
        });

        Gate::define('student', function (User $user) {
            return $user->role === 'student';
        });
        Gate::define('atc', function (User $user) {
            return $user->role === 'atc';
        });
        Gate::define('applicant', function (User $user) {
            return $user->role === 'applicant';
        });

        // Bypass maintenance mode
        Gate::define('bypass-maintenance', function (User $user) {
            return $user->role === 'superadmin';
        });

        // Superadmin has all permissions
        Gate::before(function ($user) {
            return $user->role === 'superadmin' ? true : null;
        });
    }
}