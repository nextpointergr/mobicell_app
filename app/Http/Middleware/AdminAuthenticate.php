<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate;

class AdminAuthenticate extends Authenticate
{
    protected function redirectTo($request): ?string
    {
        if (! $request->expectsJson()) {
            return route('admin.login');
        }

        return null;
    }
}
