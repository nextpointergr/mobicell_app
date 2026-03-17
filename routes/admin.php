<?php


use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::middleware('guest:admin')->group(function () {

    Volt::route('admin', 'pages.admin.auth.login')
        ->name('admin.login');
});

Route::middleware(['auth:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::post('logout', App\Livewire\Actions\AdminLogout::class)
            ->name('logout');
        Route::get('/dashboard', \App\Livewire\Admin\Dashboard\Index::class)->name('dashboard');

        Route::middleware('admin.permission')->group(function () {





            Route::get('stores', \App\Livewire\Admin\Stores\Index::class)->name('stores')
                ->defaults('permission_label','View Stores');

            Route::get('stores/create',\App\Livewire\Admin\Stores\Form::class)->name('stores.create')
            ->defaults('permission_label','Create New Store');
            Route::get('stores/edit/{id}',\App\Livewire\Admin\Stores\Form::class)->name('stores.edit')->defaults('permission_label','Edit Store');
            Route::get('stores/delete/{id}',\App\Livewire\Admin\Stores\Delete::class)->name('stores.delete')->defaults('permission_label','Delete Store');





            /****************************************** ROLES **********************************/
            Route::get('roles',\App\Livewire\Admin\Teams\Roles\Index::class)->name('roles')->defaults('permission_label','View Roles');
            Route::get('roles/create',\App\Livewire\Admin\Teams\Roles\Form::class)->name('roles.create')->defaults('permission_label','Create Role');
            Route::get('roles/{role}/edit', \App\Livewire\Admin\Teams\Roles\Form::class)->name('roles.edit')->defaults('permission_label','Edit Role');
            Route::get('roles/{role}/permissions', \App\Livewire\Admin\Teams\Roles\GivePermission::class)->name('roles.permissions')->defaults('permission_label','Manage Role Permissions');
            Route::get('roles/{role}/delete', \App\Livewire\Admin\Teams\Roles\Delete::class)->name('roles.delete')->defaults('permission_label','Delete Role');
            /****************************************** END ROLES **********************************/

            /****************************************** SETTINGS **********************************/
            Route::get('settings/general', \App\Livewire\Admin\Settings\Generally\Index::class)->name('settings.general')->defaults('permission_label','Manage General Settings');
            Route::get('settings/smtp',App\Livewire\Admin\Settings\Smtp\Index::class)->name('settings.smtp')->defaults('permission_label','Manage SMTP Settings');
            Route::get('settings/api_token', App\Livewire\Admin\Settings\Api\Index::class)->name('settings.api_token')->defaults('permission_label','Manage API Token');
            Route::get('settings/performance',App\Livewire\Admin\Settings\System\Index::class)->name('settings.performance')->defaults('permission_label','Manage Performance Settings');
            Route::get('settings/personal_info', App\Livewire\Admin\Settings\Profil\Index::class)
                ->name('settings.info');
            Route::get('settings/interface' , \App\Livewire\Admin\Settings\Interface\Index::class)->name('settings.interfaces')->defaults('permission_label','View Settings Interfaces');




            Route::post('system/run-commands', [\App\Http\Controllers\SystemCommandsController::class, 'run'])// βάλε και role middleware αν έχεις
            ->name('system.run-commands')->defaults('permission_label','Execute System Commands');


            Route::get('system/logs', \App\Livewire\Admin\System\Logs\Index::class)->name('system.logs')->defaults('permission_label','View System Logs');
            Route::get('system/jobs', \App\Livewire\Admin\System\Crons\Index::class)->name('system.jobs')->defaults('permission_label','View System Cron Jobs');

        });







        Route::get('jobs', \App\Livewire\Admin\Jobs\Index::class)->name('jobs')->defaults('permission_label', 'View Jobs');





        Route::middleware(['smtp'])->group(function () {
            /****************************************** EMPLOYEES **********************************/
            Route::get('employees', \App\Livewire\Admin\Teams\Employees\Index::class)->name('employees')->defaults('permission_label', 'View Employees');
            Route::get('employees/create', \App\Livewire\Admin\Teams\Employees\Form::class)->name('employees.create')->defaults('permission_label', 'Create Employee');
            Route::get('employees/{employee}/edit', \App\Livewire\Admin\Teams\Employees\Form::class)->name('employees.edit')->defaults('permission_label', 'Edit Employee');
            Route::get('employees/{admin}/delete', \App\Livewire\Admin\Teams\Employees\Delete::class)
                ->name('employees.delete')->defaults('permission_label', 'Delete Employee');
            /****************************************** END EMPLOYEES **********************************/
        });
        /****************************************** PERMISSIONS **********************************/
        Route::get('permissions',\App\Livewire\Admin\Teams\Permissions\Index::class)->name('permissions')->defaults('permission_label','Manage Permissions');
        /****************************************** END PERMISSIONS **********************************/



        /****************************************** ROLES **********************************/
        Route::get('roles',\App\Livewire\Admin\Teams\Roles\Index::class)->name('roles')->defaults('permission_label','View Roles');
        Route::get('roles/create',\App\Livewire\Admin\Teams\Roles\Form::class)->name('roles.create')->defaults('permission_label','Create Role');
        Route::get('roles/{role}/edit', \App\Livewire\Admin\Teams\Roles\Form::class)->name('roles.edit')->defaults('permission_label','Edit Role');
        Route::get('roles/{role}/permissions', \App\Livewire\Admin\Teams\Roles\GivePermission::class)->name('roles.permissions')->defaults('permission_label','Manage Role Permissions');
        Route::get('roles/{role}/delete', \App\Livewire\Admin\Teams\Roles\Delete::class)->name('roles.delete')->defaults('permission_label','Delete Role');
        /****************************************** END ROLES **********************************/



    });

