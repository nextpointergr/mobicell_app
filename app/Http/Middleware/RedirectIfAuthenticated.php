<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
class RedirectIfAuthenticated
{
    public function handle($request, Closure $next, ...$guards)
    {
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return match ($guard) {
                    'admin' => redirect()->route('admin.dashboard'),
                    'web'   => redirect()->route('dashboard'),
                    default => redirect('/'),
                };
            }
        }

        return $next($request);
    }
}
