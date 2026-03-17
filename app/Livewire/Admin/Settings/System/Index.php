<?php

namespace App\Livewire\Admin\Settings\System;

use App\Livewire\Admin\AComponent;
use Livewire\Component;

class Index extends AComponent
{
    public string $activeTab = 'performance';

    public array $selected = [];

    // Όλα τα keys που υπάρχουν στο UI
    public array $allKeys = [
        'cache_clear',
        'config_clear',
        'route_clear',
        'event_clear',
        'optimize_clear',
        'config_cache',
        'route_cache',
        'view_cache',
        'event_cache',
        'queue_restart',
        'schedule_run',
        'storage_link',
    ];

    public function selectAll(): void
    {
        $this->selected = $this->allKeys;
    }

    public function deselectAll(): void
    {
        $this->selected = [];
    }

    public function runSelected(): void
    {
        if (empty($this->selected)) {
            $this->dispatch('notify', type: 'warning', message: 'No actions selected');
            return;
        }

        $keys = $this->selected;
        $this->selected = [];

        $this->dispatch('run-commands', keys: $keys);
    }

    public function render()
    {
        return view('livewire.admin.settings.system.index');
    }
}
