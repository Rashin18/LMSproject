<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Setting;

class CheckMaintenanceMode
{
    // URLs that should bypass maintenance mode
    protected $except = [
        'superadmin*',  // All superadmin routes (notice the *)
        'login',        // Login page
        'password*',    // Password reset routes
        'maintenance*', // Maintenance control routes
    ];
    

    public function handle(Request $request, Closure $next)
    {
        // First check if user is superadmin - let them through immediately
        if (Auth::check() && Auth::user()->role === 'superadmin') {
            return $next($request);
        }
        \Log::info('Maintenance check', [
            'user' => Auth::user() ? Auth::user()->role : 'guest',
            'path' => $request->path(),
            'is_superadmin' => Auth::check() && Auth::user()->role === 'superadmin',
            'matches' => collect($this->except)->map(fn($e) => $request->is($e))->toArray()
        ]);

        // Then check URL patterns
        foreach ($this->except as $except) {
            if ($request->is($except)) {
                return $next($request);
            }
        }
        
        // Finally check maintenance mode
        $maintenance = Setting::where('key', 'maintenance_mode')->first();

        if ($maintenance && $maintenance->value == '1') {
            return response()->view('errors.503', [], 503);
        }

        return $next($request);
       
    }
}