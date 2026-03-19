<?php

namespace App\Livewire\Admin\Suppliers;
use App\Models\Supplier;
use App\Livewire\Admin\AComponent;
use App\Models\SupplierFieldMapping;
use Prewk\XmlStringStreamer;
use Prewk\XmlStringStreamer\Stream;
use Prewk\XmlStringStreamer\Parser;
use Illuminate\Support\Facades\Schema;
use Prewk\XmlStringStreamer\Stream\File; // Άλλαξε το include
class _MappingFields extends AComponent
{


    public $supplier;
    public $xmlFields = [];
    public $dbFields = [];
    public $mappings = []; // Form data: ['xml_field' => 'db_field']
    public $step = 1; // 1: Load, 2: Map

    public function mount($supplier)
    {
        $this->supplier = Supplier::findOrFail($supplier);
        $this->dbFields = Schema::getColumnListing('supplier_products');

        // Φόρτωση υπαρχόντων mappings αν υπάρχουν
        $existing = SupplierFieldMapping::where('supplier_id', $this->supplier->id)->get();
        foreach ($existing as $map) {
            $this->mappings[$map->source_field] = $map->target_field;
        }
    }

    public function analyzeXml()
    {
        try {
            $url = $this->supplier->source_url;
            $stream = new File($url, 1024);
            $parser = new Parser\UniqueNode(['uniqueNode' => $this->supplier->unique_node]);
            $streamer = new XmlStringStreamer($parser, $stream);

            if ($node = $streamer->getNode()) {
                $xml = simplexml_load_string($node);
                // Μετατροπή σε array για να πάρουμε τα keys (πεδία)
                $array = json_decode(json_encode($xml), true);
                $this->xmlFields = array_keys($this->flattenArray($array));
                $this->step = 2;
            } else {
                $this->alert('error', 'Δεν βρέθηκε το node: ' . $this->supplier->unique_node);
            }
        } catch (\Exception $e) {
            $this->alert('error', 'Σφάλμα ανάγνωσης: ' . $e->getMessage());
        }
    }

    // Helper για nested XML (π.χ. <images><image>...)
    private function flattenArray($array, $prefix = '') {
        $result = [];
        foreach ($array as $key => $value) {
            if (is_array($value) && !empty($value)) {
                $result = array_merge($result, $this->flattenArray($value, $prefix . $key . '.'));
            } else {
                $result[$prefix . $key] = $value;
            }
        }
        return $result;
    }

    public function saveMapping()
    {
        foreach ($this->mappings as $source => $target) {
            if (!$target) continue; // Παράλειψη αν δεν έχει επιλεγεί db field

          $data [] = $source;
            SupplierFieldMapping::updateOrCreate(
                ['supplier_id' => $this->supplier->id, 'source_field' => $source],
                ['target_field' => $target, 'target_table' => 'supplier_products', 'active' => true]
            );
        }


        $this->dispatch('notify','ok');
    }
    public function render()
    {
        return view('livewire.admin.suppliers.mapping-fields');
    }
}
