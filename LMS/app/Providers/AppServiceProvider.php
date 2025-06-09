<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Announcement;
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
    public function boot()
{
    View::composer('*', function ($view) {
        $activeAnnouncements = cache()->remember('active-announcements', 60, function () {
            return Announcement::where('is_active', true)
                ->where(function($query) {
                    $query->whereNull('start_at')
                          ->orWhere('start_at', '<=', now());
                })
                ->where(function($query) {
                    $query->whereNull('end_at')
                          ->orWhere('end_at', '>=', now());
                })
                ->latest()
                ->get();
        });
        
        $view->with('activeAnnouncements', $activeAnnouncements);
    });
}
}
