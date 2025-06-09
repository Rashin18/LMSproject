<?php
// app/Http/Middleware/RoleMiddleware.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // User must be authenticated (already handled by 'auth' middleware)
        if (!Auth::check()) {
            abort(403, 'Unauthorized');
        }

        // Check if user has any of the required roles
        foreach ($roles as $role) {
            if (Auth::user()->hasRole($role)) {
                return $next($request);
            }
        }

        abort(403, 'Insufficient permissions');
    }
}