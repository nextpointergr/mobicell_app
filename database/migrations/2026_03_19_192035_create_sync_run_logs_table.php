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
        Schema::create('sync_run_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sync_run_id')->constrained('sync_runs')->cascadeOnDelete();

            $table->string('source');
            $table->string('entity');
            $table->string('external_id')->nullable();

            $table->string('action'); // created, updated, deleted, restored, failed
            $table->string('status')->default('success'); // success,error
            $table->text('message')->nullable();

            $table->json('old_payload')->nullable();
            $table->json('new_payload')->nullable();
            $table->json('meta')->nullable();

            $table->timestamp('created_at')->useCurrent();

            $table->index(['sync_run_id', 'action']);
            $table->index(['source', 'entity', 'external_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sync_run_logs');
    }
};
