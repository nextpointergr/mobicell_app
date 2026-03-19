<?php

namespace App\Jobs\Suppliers;

use App\Models\{Supplier, SyncRun, SupplierProduct, SupplierFieldMapping, ProductConflict, ExternalSync};
use App\Events\SyncProgressUpdated;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\{DB, Log};

class SyncXmlProductsChunkJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 300; // 5 λεπτά για κάθε chunk
    public $tries = 3;

    public function __construct(
        public int $supplierId,
        public int $runId,
        public int $offset = 0,
        public int $limit = 1000
    ) {}

    public function handle(): void
    {
        $supplier = Supplier::findOrFail($this->supplierId);
        $run = SyncRun::findOrFail($this->runId);

        if ($run->status !== 'running') return;

        // 1. Προετοιμασία Mappings
        $mappings = SupplierFieldMapping::where('supplier_id', $supplier->id)->where('active', true)->get();
        $hashFields = $mappings->where('is_hashable', true)->pluck('target_field')->toArray();
        $uniqueCheckFields = $mappings->where('is_unique_check', true)->pluck('target_field', 'source_field')->toArray();

        // 2. ΒΕΛΤΙΣΤΟΠΟΙΗΣΗ: Φόρτωση όλων των hashes ΚΑΙ των unique fields στη μνήμη
        // Φορτώνουμε external_id, hash και όποιο πεδίο έχει μαρκαριστεί ως unique (π.χ. ean)
        $selectFields = array_merge(['external_id', 'hash'], array_values($uniqueCheckFields));

        $existingProducts = DB::table('supplier_products')
            ->where('supplier_id', $this->supplierId)
            ->select($selectFields)
            ->get();

        $existingHashes = $existingProducts->pluck('hash', 'external_id')->toArray();

        // Φτιάχνουμε lookups για γρήγορο conflict check: $lookups['ean']['12345'] = 'ext_id_678'
        $lookups = [];
        foreach ($uniqueCheckFields as $target) {
            $lookups[$target] = $existingProducts->pluck('external_id', $target)->filter()->toArray();
        }

        // 3. Streamer Setup
        $stream = new \Prewk\XmlStringStreamer\Stream\File($supplier->source_url, 16384);
        $parser = new \Prewk\XmlStringStreamer\Parser\UniqueNode(['uniqueNode' => trim($supplier->unique_node)]);
        $streamer = new \Prewk\XmlStringStreamer($parser, $stream);

        $upsertData = [];
        $conflictData = [];
        $currentIndex = 0; $processedInThisChunk = 0; $skippedInThisChunk = 0;

        while ($node = $streamer->getNode()) {
            if ($currentIndex < $this->offset) { $currentIndex++; continue; }

            $xml = simplexml_load_string($node, "SimpleXMLElement", LIBXML_NOCDATA);
            if ($xml) {
                $xmlArray = json_decode(json_encode($xml), true);
                $prepared = $this->transformNode($supplier->id, $mappings, $xmlArray, $hashFields);
                $extId = $prepared['external_id'] ?? null;

                if ($extId) {
                    // --- ΕΛΕΓΧΟΣ CONFLICTS (ΣΤΗ ΜΝΗΜΗ - ΟΧΙ QUERY) ---
                    $isConflict = false;
                    foreach ($uniqueCheckFields as $source => $target) {
                        $val = $prepared[$target] ?? null;

                        // Αν η τιμή υπάρχει στη βάση ΣΕ ΑΛΛΟ external_id
                        if ($val && isset($lookups[$target][$val]) && $lookups[$target][$val] !== $extId) {
                            $conflictData[] = [
                                'source' => 'xml', 'source_entity_id' => $this->supplierId,
                                'external_id' => $extId, 'conflict_type' => "duplicate_{$target}",
                                'title' => $prepared['name'] ?? 'Duplicate',
                                'created_at' => now(), 'updated_at' => now()
                            ];
                            $isConflict = true;
                            break;
                        }
                    }

                    if ($isConflict) { $skippedInThisChunk++; $currentIndex++; $processedInThisChunk++; continue; }

                    // --- ΕΛΕΓΧΟΣ HASH ---
                    if (isset($existingHashes[$extId]) && $existingHashes[$extId] === $prepared['hash']) {
                        $skippedInThisChunk++;
                    } else {
                        $upsertData[] = $prepared;
                    }
                }
            }

            $currentIndex++;
            $processedInThisChunk++;
            if ($processedInThisChunk >= $this->limit) break;
        }

        // 4. DB Operations
        if (!empty($upsertData)) {
            $fields = array_diff(array_keys($upsertData[0]), ['supplier_id', 'external_id', 'created_at']);
            SupplierProduct::upsert($upsertData, ['supplier_id', 'external_id'], array_values($fields));
        }
        if (!empty($conflictData)) {
            ProductConflict::insertOrIgnore($conflictData);
        }

        // 5. Update Progress
        $totalProcessed = $processedInThisChunk + $skippedInThisChunk;
        if ($totalProcessed > 0) {
            $run->increment('processed', $totalProcessed);
            $run->refresh();

            event(new SyncProgressUpdated(
                entity: 'supplier_' . $this->supplierId,
                processed: $run->processed,
                runId: $run->id,
                completed: false
            ));
        }

        // 6. RECURSION: Υπάρχουν κι άλλα;
        if ($processedInThisChunk < $this->limit) {
            $this->finish($run, $supplier);
        } else {
            self::dispatch(
                supplierId: $this->supplierId,
                runId: $this->runId,
                offset: $this->offset + $this->limit,
                limit: $this->limit
            )->onQueue('xml_imports');
        }
    }

    private function transformNode($supplierId, $mappings, $xmlArray, $hashFields): array
    {
        $data = ['supplier_id' => $supplierId, 'updated_at' => now(), 'created_at' => now()];
        $hashSource = '';
        foreach ($mappings as $map) {
            $val = data_get($xmlArray, $map->source_field);
            $finalVal = is_array($val) ? json_encode($val, JSON_UNESCAPED_UNICODE) : (string)$val;
            $data[$map->target_field] = $finalVal;
            if (in_array($map->target_field, $hashFields)) $hashSource .= $finalVal;
        }
        $data['hash'] = md5($hashSource);
        return $data;
    }

    private function checkDuplicate($field, $value, $extId): bool
    {
        return DB::table('supplier_products')
            ->where('supplier_id', $this->supplierId)
            ->where($field, $value)
            // ΕΔΩ ΕΙΝΑΙ ΤΟ ΚΛΕΙΔΙ:
            // Αν το βρεις σε ΑΛΛΟ external_id, τότε και μόνο τότε είναι conflict.
            ->where('external_id', '!=', $extId)
            ->exists();
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
