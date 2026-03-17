<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Spatie\Permission\Models\Permission;

class AdminPermissionMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth('admin')->user();

        if (! $user) {
            abort(403);
        }

        // 🔒 system admin → full access
        if ($user->is_system) {
            return $next($request);
        }

        $routeName = $request->route()?->getName();

        if (! $routeName) {
            return $next($request);
        }


        if ($user->can($routeName)) {
            return $next($request);
        }

        abort(403);
    }
}
