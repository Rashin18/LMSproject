<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public static function redirectToDashboard()
{
    $user = auth()->user();

    if (!$user) {
        return route('login'); // fallback if not logged in
    }

    switch ($user->role) {
        case 'superadmin':
            return route('superadmin.dashboard');
        case 'admin':
            return route('admin.dashboard');
        case 'teacher':
            return route('teacher.dashboard');
        case 'student':
            return route('student.dashboard');
        case 'atc':
            return route('atc.dashboard');
        case 'applicant':
            return route('applicant.dashboard');
        default:
            return route('home'); // fallback route
    }
}

    

    public function boot(): void
    {
        parent::boot();
        $this->routes(function () {
            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));
        });
    }
}
