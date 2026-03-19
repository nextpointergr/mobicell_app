<?php

namespace App\Jobs\Suppliers;

use App\Models\{Supplier, SyncRun};
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class DispatchXmlSupplierSyncJob implements ShouldQueue
{
    use Dispatchable, Queueable;

    public function __construct(public int $supplierId) {}

    public function handle(): void
    {
        $supplier = Supplier::findOrFail($this->supplierId);

        // Count records (ελαφρύ)
        $xmlContent = file_get_contents($supplier->source_url);
        $totalCount = substr_count($xmlContent, "<{$supplier->unique_node}");

        $run = SyncRun::create([
            'source'        => 'xml_supplier',
            'entity'        => 'supplier_' . $supplier->id,
            'direction'     => 'import',
            'status'        => 'running',
            'processed'     => 0,
            'total_records' => $totalCount,
            'total'         => $totalCount,
            'started_at'    => now(),
        ]);

        // Ξεκινάμε το ΠΡΩΤΟ chunk
        SyncXmlProductsChunkJob::dispatch(
            supplierId: $supplier->id,
            runId: $run->id,
            offset: 0
        )->onQueue('xml_imports');
    }
}
