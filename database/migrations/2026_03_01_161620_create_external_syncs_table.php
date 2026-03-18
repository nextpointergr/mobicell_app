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
        Schema::create('external_syncs', function (Blueprint $table) {
            $table->id();
            $table->string('source');
            $table->string('entity');
            $table->timestamp('last_synced_at')->nullable();
            $table->string('last_cursor')->nullable();
            $table->timestamps();
            $table->unique(['source', 'entity']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('external_syncs');
    }
};
