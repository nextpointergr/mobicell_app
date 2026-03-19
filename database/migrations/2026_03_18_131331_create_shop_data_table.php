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
        Schema::create('shop_data', function (Blueprint $table) {
            $table->id();
            $table->string('source')->default('prestashop');
            $table->string('type');
            $table->string('external_id');
            $table->string('hash', 32);
            $table->longText('payload');
            $table->timestamp('last_synced_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['source', 'type', 'external_id'], 'shop_data_unique_index');
            $table->index(['source', 'type']);
            $table->index(['type', 'deleted_at']);
            $table->index(['last_synced_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_data');
    }
};
