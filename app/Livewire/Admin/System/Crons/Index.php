<?php

namespace App\Livewire\Admin\System\Crons;

use App\Livewire\Admin\AComponent;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class Index extends AComponent
{
    public array $scheduled = [];
    public array $queueStats = [];

    public function mount()
    {
        $this->loadScheduled();
        $this->loadQueueStats();
    }

    protected function loadScheduled(): void
    {
        Artisan::call('schedule:list');

        $output = Artisan::output();

        $this->scheduled = collect(explode("\n", $output))
            ->filter(fn ($line) => str_contains($line, 'logs:'))
            ->values()
            ->toArray();
    }

    protected function loadQueueStats(): void
    {
        $this->queueStats = [
            'pending' => DB::table('jobs')->count(),
            'failed'  => DB::table('failed_jobs')->count(),
        ];
    }


    public function render()
    {
        return view('livewire.admin.system.crons.index');
    }
}
