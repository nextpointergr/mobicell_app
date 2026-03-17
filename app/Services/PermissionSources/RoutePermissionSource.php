<?php

namespace App\Services\PermissionSources;

use Illuminate\Support\Facades\Route;

class RoutePermissionSource
{
    protected array $excluded = [
        'admin.dashboard',
        'admin.logout',
    ];



    public function get(): array
    {
        return collect(Route::getRoutes())
            ->filter(function ($route) {
                $name = $route->getName();

                if (! $name || ! str_starts_with($name, 'admin.')) {
                    return false;
                }

                if (in_array($name, $this->excluded)) {
                    return false;
                }

                $middlewares = $route->middleware();

//                if (in_array('guest:admin', $middlewares)) {
//                    return false;
//                }
//
//                return in_array('auth:admin', $middlewares);

                return in_array('admin.permission', $middlewares);
            })
            ->map(fn ($route) => [
                'name'   => $route->getName(),
                'guard'  => 'admin',
                'label' => $route->defaults['permission_label'] ?? null,
                'group'  => 'routes',
                'source' => 'route',
            ])
            ->unique('name')
            ->values()
            ->toArray();
    }
}
