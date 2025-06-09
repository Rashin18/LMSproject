<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\LogActivity;

class LogActivityMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (auth()->check() && !$request->is('superadmin/reports*')) {
            LogActivity::create([
                'user_id' => auth()->id(),
                'action' => $request->method() . ' ' . $request->path(),
                'details' => json_encode([
                    'params' => $request->except(['password', '_token']),
                    'url' => $request->fullUrl()
                ]),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'method' => $request->method()
            ]);
        }

        return $response;
    }
}
