<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $role = Role::firstOrCreate(
            [
                'name'       => 'Super Admin',
                'guard_name' => 'admin',
            ],
            [
                'is_system' => true,
            ]
        );

        $admin = Employee::updateOrCreate(
            [
                'email' => 'info@nextpointer.gr',
            ],
            [
                'name'     => 'Super Admin',
                'password' => Hash::make('admin123'),
                'is_system' => true

            ]
        );

        if (! $admin->hasRole($role->name, 'admin')) {
            $admin->assignRole($role);
        }
    }
}
