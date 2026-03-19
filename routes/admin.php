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


            Route::get('suppliers', \App\Livewire\Admin\Suppliers\Index::class)->name('suppliers')->defaults('permission_label','View Suppliers');
            Route::get('suppliers/create', \App\Livewire\Admin\Suppliers\Form::class)->name('suppliers.create')->defaults('permission_label', 'Create Supplier');
            Route::get('supplier/{supplier}/edit' , \App\Livewire\Admin\Suppliers\Form::class)->name('suppliers.edit')->defaults('permission_label', 'Edit Supplier');
            Route::get('supplier/{supplier}/delete' , \App\Livewire\Admin\Suppliers\Delete::class)->name('suppliers.delete')->defaults('permission_label', 'Edit Supplier');
            Route::get('supplier/{supplier}/mapping' , \App\Livewire\Admin\Suppliers\MappingFields::class)->name('suppliers.mapping')->defaults('permission_label', 'mapping Supplier');
            Route::get('suppliers/sync'
                , \App\Livewire\Admin\Suppliers\Sync::class)->name('suppliers.sync')->defaults('permission_label', 'mapping Supplier');




            Route::get('products', \App\Livewire\Admin\Catalog\Products\Index::class)->name('products')->defaults('permission_label','View Catalog Products');




            Route::get('stores', \App\Livewire\Admin\Stores\Index::class)->name('stores')
                ->defaults('permission_label','View Stores');

            Route::get('stores/create',\App\Livewire\Admin\Stores\Form::class)->name('stores.create')
            ->defaults('permission_label','Create New Store');
            Route::get('stores/edit/{store}',\App\Livewire\Admin\Stores\Form::class)->name('stores.edit')->defaults('permission_label','Edit Store');
            Route::get('stores/delete/{store}',\App\Livewire\Admin\Stores\Delete::class)->name('stores.delete')->defaults('permission_label','Delete Store');





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


        Route::get('pylon/m/categories', \App\Livewire\Admin\Pylon\Mapping\Index::class)->name('pylon.categories')
            ->defaults('permission_label','View Pylon Categories');

        Route::get('pylon/m/payments', \App\Livewire\Admin\Pylon\Mapping\Index::class)->name('pylon.payments')
            ->defaults('permission_label','View Pylon payments');

        Route::get('pylon/m/shippings', \App\Livewire\Admin\Pylon\Mapping\Index::class)->name('pylon.shippings')
            ->defaults('permission_label','View Pylon Shipments');


        Route::get('pylon/settings', \App\Livewire\Admin\Pylon\Settings\Index::class)->name('pylon.settings')
            ->defaults('permission_label','View Pylon Settings');


        Route::get('pylon/statistics', \App\Livewire\Admin\Pylon\Statistics\Index::class)->name('pylon.stats')
            ->defaults('permission_label','View Pylon Statistics');

        Route::get('pylon/sync', \App\Livewire\Admin\Pylon\Sync\Index::class)->name('pylon.sync')
            ->defaults('permission_label','View Pylon Sync');


        Route::get('shop/sync', \App\Livewire\Admin\Shop\Sync\Index::class)->name('shop.sync');

});


