<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('X-API-TOKEN-NEXTPOINTER'); // 62373353-ab18-4be2-afe4-7204deb839af

        if ($token !== getApiKey()) {
            return response()->json([
                'message' => __('Unauthorized'),
            ], 401);
        }

        return $next($request);
    }
}
