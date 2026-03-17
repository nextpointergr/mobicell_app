<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Setting;

class EnsureSmtpConfigured
{
    public function handle(Request $request, Closure $next)
    {
        if (
            $request->routeIs('admin.settings.smtp') ||
            $request->routeIs('admin.logout')
        ) {
            return $next($request);
        }

        if (!Setting::get('mail_is_valid')) {
            return redirect()
                ->route('admin.settings.smtp')
                ->with('warning', 'You must configure SMTP before continuing.');
        }

        return $next($request);
    }
}
