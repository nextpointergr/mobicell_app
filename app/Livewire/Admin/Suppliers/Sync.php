<?php

namespace App\Livewire\Admin\Suppliers;

use App\Livewire\Admin\AComponent;
use App\Models\Supplier;
use App\Models\SyncRun;
use App\Models\SupplierProduct;
use Spatie\Activitylog\Models\Activity;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Bus;
class Sync extends AComponent
{
    public bool $isFullSync = false;
    public array $selected = [];
    public array $progress = [];
    public array $completed = [];
    public array $runs = [];
    public array $totals = [];
    public array $syncStats = [];

    public function mount(): void
    {
        $this->refreshStatus();
    }

    public function refreshStatus(): void
    {
        $suppliers = Supplier::all();

        foreach ($suppliers as $supplier) {
            $entityKey = 'supplier_' . $supplier->id;

            $run = SyncRun::where('entity', $entityKey)->latest()->first();
            $this->runs[$entityKey] = $run;

            // Αν το run τρέχει, χρησιμοποίησε το total_records του run για την μπάρα
            $this->totals[$entityKey] = ($run && $run->status === 'running')
                ? $run->total_records
                : SupplierProduct::where('supplier_id', $supplier->id)->count();

            $this->syncStats[$entityKey] = $this->getSyncStats($entityKey);
        }
    }

//    public function refreshStatus(): void
//    {
//        $suppliers = Supplier::all();
//
//        foreach ($suppliers as $supplier) {
//            $entityKey = 'supplier_' . $supplier->id;
//
//            // Σύνολο προϊόντων στη βάση για τον συγκεκριμένο προμηθευτή
//            $this->totals[$entityKey] = SupplierProduct::where('supplier_id', $supplier->id)->count();
//
//            // Τελευταίο Run για το UI
//            $this->runs[$entityKey] = SyncRun::where('entity', $entityKey)
//                ->latest()
//                ->first();
//
//            // Stats από τα logs (Created/Updated)
//            $this->syncStats[$entityKey] = $this->getSyncStats($entityKey);
//        }
//    }

    /**
     * Listener για το Event που στέλνει το Job
     */
    #[On('sync-progress')] // Ή #[On('echo:sync-channel,SyncProgressUpdated')] αν παίζεις με Websockets
    public function updateProgress($entity, $processed, $runId = null, $completed = false)
    {
        if ($completed) {
            $this->completed[$entity] = true;

            // Αφαίρεση από τα επιλεγμένα αν τελείωσε
            $this->selected = array_values(array_diff($this->selected, [$entity]));
            unset($this->progress[$entity]);

            // Έλεγχος αν τελείωσαν όλα για το "χορευτικό" GIF
            if (empty($this->selected)) {
                if ($this->isFullSync) {
                    $this->dispatch('sync-finished');
                }
                $this->isFullSync = false;
            }

            $this->refreshStatus();
            return;
        }

        // Ενημέρωση του progress bar σε πραγματικό χρόνο
        $this->progress[$entity] = $processed;
    }

    public function startFullSync(): void
    {
        $this->isFullSync = true;
        $this->selected = array_keys($this->getEntitiesProperty());
        $this->startSelected();
    }

    public function startSelected(): void
    {
        if (empty($this->selected)) return;
        $jobs = [];
        foreach ($this->selected as $entityKey) {
            $supplierId = (int) str_replace('supplier_', '', $entityKey);

            $this->progress[$entityKey] = 0;
            $this->completed[$entityKey] = false;

            $jobs[] = new \App\Jobs\Suppliers\DispatchXmlSupplierSyncJob($supplierId);
        }
        Bus::chain($jobs)->onQueue('xml_imports')->dispatch();
        $this->refreshStatus();
    }

    public function getSyncStats(string $entityKey)
    {
        $run = SyncRun::where('entity', $entityKey)->latest()->first();
        if (!$run) return ['created' => 0, 'updated' => 0];

        // Υποθέτοντας ότι καταγράφεις stats στο activity log
        $logs = Activity::query()
            ->where('log_name', 'xml_sync')
            ->where('properties->entity', $entityKey)
            ->where('properties->run_id', $run->id);

        return [
            'created' => (clone $logs)->where('description', 'create')->count(),
            'updated' => (clone $logs)->where('description', 'update')->count(),
        ];
    }

    public function getEntitiesProperty()
    {
        return Supplier::all()->mapWithKeys(function ($s) {
            return ['supplier_' . $s->id => [
                'title' => $s->name,
                'desc' => 'XML Import',
            ]];
        })->toArray();
    }

    // Selection Helpers
    public function selectAll(): void { $this->selected = array_keys($this->getEntitiesProperty()); }
    public function deselectAll(): void { $this->selected = []; $this->isFullSync = false; }
    public function toggleEntity(string $entity): void {
        $this->selected = in_array($entity, $this->selected)
            ? array_values(array_diff($this->selected, [$entity]))
            : array_merge($this->selected, [$entity]);
    }

    public function render()
    {
        return view('livewire.admin.suppliers.sync', [
            'entities' => $this->getEntitiesProperty()
        ]);
    }
}
