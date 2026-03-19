<?php

namespace App\Jobs\Suppliers;

use App\Models\Supplier;
use App\Models\SyncRun;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Bus\Batchable; // Απαραίτητο!
class DispatchXmlSupplierSyncJob implements ShouldQueue
{
    use Batchable, Dispatchable, Queueable;

    public function __construct(public int $supplierId) {}

    public function handle(): void
    {
        $supplier = Supplier::findOrFail($this->supplierId);
        $xmlContent = file_get_contents($supplier->source_url);
        $totalCount = substr_count($xmlContent, "<{$supplier->unique_node}");

        // Δημιουργία Run για tracking
        $run = SyncRun::create([
            'source'     => 'xml_supplier',
            'entity'     => 'supplier_' . $supplier->id,
            'direction'  => 'import',
            'status'     => 'running',
            'processed'  => 0,
            'total_records' => $totalCount,
            'total'       => $totalCount, // Πρέπει να έχεις αυτή τη στήλη στο migration του SyncRun
            'started_at' => now(),
        ]);

        // Εδώ είναι το "κόλπο": Εκτελούμε το ΠΡΩΤΟ chunk ΣΥΓΧΡΟΝΑ (handle)
        // μέσα στο ήδη τρέχον Job. Έτσι ο worker δεν θα ελευθερωθεί
        // μέχρι να τελειώσει ΟΛΟΣ ο προμηθευτής (γιατί το chunkJob θα καλεί τον εαυτό του sync).
        (new SyncXmlProductsChunkJob(
            supplierId: $supplier->id,
            runId: $run->id,
            offset: 0
        ))->handle();
    }
}
