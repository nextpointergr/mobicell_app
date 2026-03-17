<?php

namespace App\Livewire\Admin\Teams\Permissions;

use App\Livewire\Admin\AComponent;
use App\Services\PermissionSyncManager;


class Index extends AComponent
{

    public int $created = 0;
    public int $updated = 0;

    public function syncPermissions()
    {
        $result = app(PermissionSyncManager::class)->sync();
        $this->created = $result['created'];
        $this->updated = $result['updated'];
        $this->dispatch('notify',
            type: 'success',
            message: "Permissions synced. Created: {$this->created}, Updated: {$this->updated}"
        );
    }


    public function render()
    {
        return view('livewire.admin.teams.permissions.index');
    }
}
