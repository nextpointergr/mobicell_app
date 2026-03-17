<?php

namespace App\Providers;
use App\Services\PylonManager;
use App\Models\Employee;
use App\Models\Role;
use App\Policies\EmployeePolicy;
use App\Policies\RolePolicy;
use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->singleton(\NextPointer\Pylon\Manager\PylonManager::class, function ($app) {
            return new PylonManager([]);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Carbon::setLocale('el');
        Gate::policy(Employee::class, EmployeePolicy::class);
        Gate::policy(Role::class, RolePolicy::class);

        Gate::before(function ($user, $ability) {

            if ($ability === 'delete'){
                return null;
            }
            if ($user->is_system ?? false) {
                return true;
            }


            return null; // συνέχισε με normal permission / policy checks
        });
    }
}
