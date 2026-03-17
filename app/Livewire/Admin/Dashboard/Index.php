<?php

namespace App\Livewire\Admin\Dashboard;

use App\Livewire\Admin\AComponent;
use Livewire\Component;
use Spatie\Activitylog\Models\Activity;

class Index extends AComponent
{

    public array $stats = [];
    public $recentActivities;
    public function mount()
    {
        $this->loadDashboard();
    }


    public function render()
    {
        return view('livewire.admin.dashboard.index');
    }


    protected function loadDashboard(): void
    {


        $this->recentActivities = Activity::query()
            ->with('causer')
            ->latest()
            ->limit(5)
            ->get();






    }
}
