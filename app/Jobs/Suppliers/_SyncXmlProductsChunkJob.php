<?php

namespace App\Jobs\Suppliers;

use App\Models\ProductConflict;
use App\Models\Supplier;
use App\Models\SyncRun;
use App\Models\SupplierProduct;
use App\Models\SupplierFieldMapping;
use App\Models\ExternalSync;
use App\Events\SyncProgressUpdated;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SyncXmlProductsChunkJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 600;
    public $tries = 3;

    public function __construct(
        public int $supplierId,
        public int $runId,
        public int $offset = 0,
        public int $limit = 1000
    ) {}

  /**  public function handle(): void
    {
        $supplier = Supplier::findOrFail($this->supplierId);
        $run = SyncRun::findOrFail($this->runId);

        if ($run->status !== 'running') return;
        $existingHashes = SupplierProduct::where('supplier_id', $supplier->id)
            ->pluck('hash', 'external_id')
            ->toArray();

        // 1. Streamer Setup
        $stream = new \Prewk\XmlStringStreamer\Stream\File($supplier->source_url, 16384);
        $parser = new \Prewk\XmlStringStreamer\Parser\UniqueNode([
            'uniqueNode' => trim($supplier->unique_node)
        ]);
        $streamer = new \Prewk\XmlStringStreamer($parser, $stream);

        // 2. Mappings
        $mappings = SupplierFieldMapping::where('supplier_id', $supplier->id)
            ->where('active', true)
            ->pluck('target_field', 'source_field');

        $upsertData = [];
        $currentIndex = 0;
        $itemsInThisChunk = 0;
        // --- ΠΡΟΣΘΗΚΗ: Μετρητής για τα προϊόντα που ΔΕΝ άλλαξαν σε αυτό το chunk ---
        $skippedInThisChunk = 0;

        while ($node = $streamer->getNode()) {
            if ($currentIndex < $this->offset) {
                $currentIndex++;
                continue;
            }

            $xml = simplexml_load_string($node, "SimpleXMLElement", LIBXML_NOCDATA);
            if ($xml) {
                $xmlArray = json_decode(json_encode($xml), true);
                $prepared = $this->transformNode($supplier->id, $mappings, $xmlArray);

                // Μόνο αν έχουμε external_id το βάζουμε για upsert
                if (!empty($prepared['external_id'])) {
                    // --- ΠΡΟΣΘΗΚΗ/ΑΛΛΑΓΗ ΕΔΩ ---
                    $extId = $prepared['external_id'];
                    $newHash = $prepared['hash'];

                    // Αν το hash είναι ολόιδιο
                    if (isset($existingHashes[$extId]) && $existingHashes[$extId] === $newHash) {
                        $skippedInThisChunk++;
                    } else {
                        $upsertData[] = $prepared;
                    }
                }
            }

            $currentIndex++;
            $itemsInThisChunk++;

            if ($itemsInThisChunk >= $this->limit) break;
        }

        // 3. Upsert Logic
        if (!empty($upsertData)) {
            // Καθαρισμός διπλοτύπων στο ίδιο το batch
            $upsertData = collect($upsertData)->unique('external_id')->values()->all();

            $uniqueBy = ['supplier_id', 'external_id'];
            $allFields = array_keys($upsertData[0]);
            $updateFields = array_values(array_diff($allFields, $uniqueBy, ['created_at']));

            try {
                DB::transaction(function () use ($upsertData, $uniqueBy, $updateFields) {

                    // Χρησιμοποιούμε το Model με το guarded=[] για να δουλέψει το upsert
                    SupplierProduct::upsert($upsertData, $uniqueBy, $updateFields);
                });



            } catch (\Exception $e) {
                Log::error("Upsert Failed: " . $e->getMessage());
                // Αν θέλεις να σταματήσει η ουρά σε λάθος, βγάλε το σχόλιο:
                // throw $e;
            }
        }

        // --- ΠΡΟΣΘΗΚΗ: Συνολική ενημέρωση του progress στο τέλος του Chunk ---
        // Υπολογίζουμε πόσα επεξεργαστήκαμε συνολικά (αυτά που γράψαμε + αυτά που προσπεράσαμε)
        $processedInBatch = count($upsertData) + $skippedInThisChunk;

        if ($processedInBatch > 0) {
            // Ενημερώνουμε τη βάση (SyncRun)
            $run->increment('processed', $processedInBatch);

            // Στέλνουμε ΤΟ event για να κουνηθεί η μπάρα
            event(new SyncProgressUpdated(
                entity: 'supplier_' . $this->supplierId,
                processed: $run->processed,
                runId: $run->id,
                completed: false
            ));
        }

        // 4. Επόμενο Chunk ή Τέλος
        if ($itemsInThisChunk < $this->limit) {
            $this->finish($run, $supplier);
        } else {
//            self::dispatch($this->supplierId, $this->runId, $this->offset + $this->limit, $this->limit)
//                ->onQueue('xml_imports');
            $this->offset += $this->limit;
            $this->handle();
        }
    } **/



    public function handle(): void
    {
        $supplier = Supplier::findOrFail($this->supplierId);
        $run = SyncRun::findOrFail($this->runId);

        if ($run->status !== 'running') return;

        // 1. Προετοιμασία
        $existingHashes = SupplierProduct::where('supplier_id', $supplier->id)
            ->pluck('hash', 'external_id')
            ->toArray();

        $stream = new \Prewk\XmlStringStreamer\Stream\File($supplier->source_url, 16384);
        $parser = new \Prewk\XmlStringStreamer\Parser\UniqueNode(['uniqueNode' => trim($supplier->unique_node)]);
        $streamer = new \Prewk\XmlStringStreamer($parser, $stream);

        $mappings = SupplierFieldMapping::where('supplier_id', $supplier->id)
            ->where('active', true)
            ->pluck('target_field', 'source_field')
            ->toArray();

        $upsertData = [];
        $conflictData = [];
        $idsToDelete = [];
        $seenInBatchIds = [];
        $currentIndex = 0;
        $itemsInThisChunk = 0;
        $skippedInThisChunk = 0; // Επαναφορά του skipped counter που δούλευε

        while ($node = $streamer->getNode()) {
            if ($currentIndex < $this->offset) { $currentIndex++; continue; }

            $xml = simplexml_load_string($node, "SimpleXMLElement", LIBXML_NOCDATA);
            if ($xml) {
                $xmlArray = json_decode(json_encode($xml), true);
                $prepared = $this->transformNode($supplier->id, $mappings, $xmlArray);
                $extId = $prepared['external_id'] ?? null;

                if ($extId) {
                    // ΕΛΕΓΧΟΣ ΔΙΠΛΟΤΥΠΟΥ (Conflict)
                    if (in_array($extId, $seenInBatchIds)) {
                        $conflictData[] = [
                            'source' => 'xml',
                            'source_entity_id' => $this->supplierId,
                            'external_id' => $extId,
                            'title' => $prepared['name'] ?? 'Duplicate ID',
                            'conflict_type' => 'duplicate_external_id',
                            'payload' => json_encode(['raw' => $xmlArray], JSON_UNESCAPED_UNICODE),
                            'created_at' => now(), 'updated_at' => now(),
                        ];
                        $idsToDelete[] = $extId; // Μαρκάρουμε για διαγραφή από τα κανονικά
                        $skippedInThisChunk++;
                        continue;
                    }

                    // ΕΛΕΓΧΟΣ HASH
                    if (isset($existingHashes[$extId]) && $existingHashes[$extId] === $prepared['hash']) {
                        $skippedInThisChunk++;
                        $seenInBatchIds[] = $extId;
                        continue;
                    }

                    // ΠΡΟΣ UPSERT
                    $upsertData[] = $prepared;
                    $seenInBatchIds[] = $extId;
                }
            }

            $currentIndex++;
            $itemsInThisChunk++;
            if ($itemsInThisChunk >= $this->limit) break;
        }

        // --- DB OPERATIONS (Μετά το loop για ταχύτητα) ---

        if (!empty($idsToDelete)) {
            SupplierProduct::where('supplier_id', $this->supplierId)->whereIn('external_id', $idsToDelete)->delete();
        }

        if (!empty($conflictData)) {
            ProductConflict::insertOrIgnore($conflictData);
        }

        if (!empty($upsertData)) {
            $uniqueBy = ['supplier_id', 'external_id'];
            $updateFields = array_values(array_diff(array_keys($upsertData[0]), $uniqueBy, ['created_at']));
            DB::transaction(fn() => SupplierProduct::upsert($upsertData, $uniqueBy, $updateFields));
        }

        // --- PROGRESS UPDATE (Όπως ακριβώς δούλευε στην αρχή) ---
        $totalProcessedInBatch = count($upsertData) + $skippedInThisChunk;

        if ($totalProcessedInBatch > 0) {
            $run->increment('processed', $totalProcessedInBatch);

            event(new SyncProgressUpdated(
                'supplier_' . $this->supplierId,
                $run->processed,
                $run->id,
                false
            ));
        }

        // Επόμενο Chunk
        if ($itemsInThisChunk < $this->limit) {
            $this->finish($run, $supplier);
        } else {
            $this->offset += $this->limit;
            $this->handle();
        }
    }

    private function transformNode(int $supplierId, $mappings, array $xmlData): array
    {
        $now = now()->toDateTimeString();

        // 1. Βασικά πεδία που δεν αλλάζουν
        $data = [
            'supplier_id' => $supplierId,
            'created_at'  => $now,
            'updated_at'  => $now,
        ];

        // 2. Δυναμικό γέμισμα από τα Mappings
        // Εδώ θα μπει και το external_id αν το έχεις αντιστοιχίσει στο UI
        $hashSource = '';

        foreach ($mappings as $source => $target) {
            // Τραβάμε την τιμή από το XML βάσει του mapping
            $value = data_get($xmlData, $source);

            // Μετατροπή σε string/json
            $finalValue = $value !== null
                ? (is_array($value) ? json_encode($value, JSON_UNESCAPED_UNICODE) : (string)$value)
                : null;

            // Τοποθέτηση στο σωστό πεδίο (π.χ. $data['external_id'], $data['price'], κλπ)
            $data[$target] = $finalValue;

            // Χτίζουμε το hash source ΜΟΝΟ από τα πεδία του mapping
            $hashSource .= (string)$finalValue;
        }

        // 3. Δημιουργία Hash για σύγκριση αλλαγών
        $data['hash'] = md5($hashSource);

        return $data;
    }

    private function finish(SyncRun $run, Supplier $supplier): void
    {
        ExternalSync::updateOrCreate(
            ['source' => 'xml', 'entity' => 'supplier_' . $supplier->id],
            ['last_synced_at' => now()]
        );

        $run->update(['status' => 'completed', 'finished_at' => now()]);

        event(new SyncProgressUpdated(
            entity: 'supplier_' . $supplier->id,
            processed: $run->processed,
            runId: $run->id,
            completed: true
        ));
    }
}
