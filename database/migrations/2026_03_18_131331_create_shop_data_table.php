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
            $table->string('source')->default('prestashop')->nullable();
            $table->string('type');
            $table->string('external_id');

            $table->string('hash');
            $table->json('payload');
            $table->timestamp('last_synced_at')->nullable();
            $table->timestamps();

            // Σύνθετο Unique Index για να λειτουργεί σωστά το upsert
            // και να μην υπάρχουν συγκρούσεις μεταξύ διαφορετικών types
            $table->unique(['source', 'type', 'external_id'], 'shop_data_unique_index');
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
