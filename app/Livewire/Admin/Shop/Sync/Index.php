<?php

namespace App\Livewire\Admin\Shop\Sync;

use App\Jobs\shop\DispatchPrestashopGenericSyncJob;
use App\Livewire\Admin\AComponent;
use App\Models\SyncRun;
use Spatie\Activitylog\Models\Activity;
use App\Models\ShopData;
use Illuminate\Support\Facades\Bus;
use Livewire\Attributes\On;
class Index extends AComponent
{


    /* -----------------------------------------------------------------
     | ENTITIES CONFIG
     |-----------------------------------------------------------------*/
    protected array $entities = [
        'categories' => [
            'job' => DispatchPrestashopGenericSyncJob::class,
            'queue' => 'prestashop',
            'title' => 'Categories',
            'desc' => 'Categories',
        ],

        'carriers' => [
            'job' => DispatchPrestashopGenericSyncJob::class,
            'queue' => 'prestashop',
            'title' => 'Carriers',
            'desc' => 'Carriers',
        ],

        'taxes' => [
            'job' => DispatchPrestashopGenericSyncJob::class,
            'queue' => 'prestashop',
            'title' => 'Taxes',
            'desc' => 'Taxes',
        ],

        'payments' => [
            'job' => DispatchPrestashopGenericSyncJob::class,
            'queue' => 'prestashop',
            'title' => 'Payments',
            'desc' => 'Payments',
        ],
    ];

    public array $selected = [];
    public array $progress = [];
    public array $completed = [];
    public array $syncStats = [];
    public array $totals = [];
    public array $runs = [];

    public function mount(): void
    {
        $this->refreshStatus();
    }

    public function refreshStatus(): void
    {
        foreach ($this->entities as $entity => $config) {

            if (in_array($entity, ['categories', 'carriers', 'payments', 'taxes', 'statuses'])) {
                $this->totals[$entity] = ShopData::where('type', $entity)->count();
            }

            $this->runs[$entity] = SyncRun::where('entity', $entity)
                ->latest()
                ->first();

            $this->syncStats[$entity] = $this->getSyncStats($entity);
        }
    }

    public function startSelected(): void
    {
        if (!$this->selected) return;

        $this->progress = [];
        $this->completed = [];
        $jobs = [];

        foreach ($this->selected as $entity) {
            $this->progress[$entity] = 0;
            $config = $this->entities[$entity];
            $jobClass = $config['job'];

            // Instantiate Job
            if ($jobClass === DispatchPrestashopGenericSyncJob::class) {
                $job = new $jobClass($entity);
            } elseif ($entity === 'prestashop_products') {
                $job = new $jobClass(500);
            } else {
                $job = new $jobClass($entity);
            }

            $job->onQueue($config['queue']);
            $jobs[$entity] = $job;
        }

        // Handle Dependencies (π.χ. Products depends on ERP Products)
        foreach ($this->selected as $entity) {
            $depends = $this->entities[$entity]['depends'] ?? null;
            if ($depends && isset($jobs[$depends])) {
                Bus::chain([$jobs[$depends], $jobs[$entity]])->dispatch();
                unset($jobs[$entity], $jobs[$depends]);
            }
        }

        foreach ($jobs as $job) {
            dispatch($job);
        }

        $this->refreshStatus();
    }

    #[On('sync-progress')]
    public function updateProgress($entity, $processed, $runId = null, $completed = false)
    {

        if ($completed) {

            $this->completed[$entity] = true;
            $this->selected = array_values(array_diff($this->selected, [$entity]));
            unset($this->progress[$entity]);

            $this->refreshStatus();

            return;
        }

        $this->progress[$entity] = $processed;
    }

    public function getSyncStats(string $entity)
    {
        $run = SyncRun::where('entity', $entity)->latest()->first();
        if (!$run) return ['created' => 0, 'updated' => 0];

        $logs = Activity::query()
            ->where('log_name', 'erp_sync')
            ->where('properties->entity', $entity)
            ->where('properties->run_id', $run->id);

        return [
            'created' => (clone $logs)->where('description', 'create')->count(),
            'updated' => (clone $logs)->where('description', 'update')->count(),
        ];
    }

    public function selectAll(): void { $this->selected = array_keys($this->entities); }
    public function deselectAll(): void { $this->selected = []; }
    public function toggleEntity(string $entity): void {
        $this->selected = in_array($entity, $this->selected)
            ? array_values(array_diff($this->selected, [$entity]))
            : array_merge($this->selected, [$entity]);
    }

    public function render()
    {
        return view('livewire.admin.shop.sync.index',[
            'entities' => $this->entities
        ]);
    }
}
