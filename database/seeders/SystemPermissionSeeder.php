<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Services\PermissionSyncManager;

class SystemPermissionSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionSyncManager::class)->sync();
    }
}
