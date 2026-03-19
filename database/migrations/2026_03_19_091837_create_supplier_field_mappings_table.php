<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('supplier_field_mappings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('supplier_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->string('source_field')
                ->comment('Όνομα πεδίου από την εξωτερική πηγή δεδομένων (XML/JSON/API/CSV)');
            $table->string('target_table')->default('supplier_products')
                ->comment('Πίνακας στόχος στη βάση (π.χ. supplier_products, products)');
            $table->string('target_field')
                ->comment('Πεδίο στη βάση που αντιστοιχεί');
            $table->boolean('required')->default(false)
                ->comment('Αν το πεδίο είναι υποχρεωτικό για εισαγωγή');
            $table->boolean('active')->default(true)
                ->comment('Αν το mapping είναι ενεργό');
            $table->timestamps();
            $table->unique(['supplier_id', 'source_field']);
            $table->index(['supplier_id', 'target_field']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_field_mappings');
    }
};
