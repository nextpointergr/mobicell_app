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
        Schema::create('supplier_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->string('external_id')->nullable()
                ->comment('ID προϊόντος από την εξωτερική πηγή');
            $table->string('ean')->nullable()->index();
            $table->string('mpn')->nullable()->index();
            $table->string('name')->nullable()->index();
            $table->mediumText('description')->nullable();
            $table->text('short_description')->nullable();
            $table->json('features')->nullable()
                ->comment('Χαρακτηριστικά προϊόντος από supplier');

            $table->json('raw_data')->nullable()
                ->comment('Raw δεδομένα από XML/JSON/API');
            $table->decimal('price', 10, 2)->nullable();
            $table->integer('stock')->nullable();
            $table->string('match_status')->default('unmatched')->index()
                ->comment('unmatched, matched, manual, duplicate, conflict');
            $table->string('import_status')->default('pending')->index()
                ->comment('pending, validated, rejected, approved, imported');
            $table->string('sync_action')->default('review')->index()
                ->comment('review, create, update, skip, needs_content');
            $table->text('notes')->nullable();
            $table->text('lookup_key')->nullable();
            $table->string('hash')->nullable()->index();
            $table->timestamps();
            $table->unique(['supplier_id', 'external_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_products');
    }
};
