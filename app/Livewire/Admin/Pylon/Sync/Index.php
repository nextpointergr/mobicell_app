<?php

namespace App\Livewire\Admin\Pylon\Sync;

use App\Jobs\pylon\DispatchPylonGenericSyncJob;
use App\Livewire\Admin\AComponent;


use App\Models\SyncRun;
use Spatie\Activitylog\Models\Activity;
use App\Models\ShopData;
use Illuminate\Support\Facades\Bus;
use Livewire\Attributes\On;

class Index extends AComponent
{
    public bool $isFullSync = false;
    /* -----------------------------------------------------------------
     | ENTITIES CONFIG
     |-----------------------------------------------------------------*/
    protected array $entities = [
        'payments' => [
            'job' => DispatchPylonGenericSyncJob::class,
            'queue' => 'pylon',
            'title' => 'Payments',
            'desc' => 'Payments',
        ],

        'shipping' => [
            'job' => DispatchPylonGenericSyncJob::class,
            'queue' => 'pylon',
            'title' => 'Carriers',
            'desc' => 'Carriers',
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

    public function startFullShopSync(): void
    {
        $this->isFullSync = true;
        $this->selectAll();
        $this->startSelected();
    }
    public function refreshStatus(): void
    {
        foreach ($this->entities as $key => $config) {
            // Παίρνουμε το σύνολο από τον πίνακα entities βάσει του type
            $this->totals[$key] = \App\Models\Entity::where('type', $config['type'] ?? $key)->count();

            $this->runs[$key] = SyncRun::where('entity', $key)
                ->where('source', 'pylon')
                ->latest()
                ->first();

            $this->syncStats[$key] = $this->getSyncStats($key);
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
            if ($jobClass === DispatchPylonGenericSyncJob::class) {
                $job = new $jobClass($entity);
            } elseif ($entity === 'products') {
                $job = new $jobClass($entity);
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

            // ΕΔΩ: Αν άδειασε η λίστα των επιλεγμένων, κλείσε το Full Sync mode
            if (empty($this->selected)) {
                if ($this->isFullSync) {
                    $this->dispatch('sync-finished'); // Στέλνει το σήμα για τον χορό!
                }

                $this->isFullSync = false;
            }
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
