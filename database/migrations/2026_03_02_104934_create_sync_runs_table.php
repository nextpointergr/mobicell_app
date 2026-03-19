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
        Schema::create('sync_runs', function (Blueprint $table) {
            $table->id();
            $table->string('source');
            $table->string('entity');
            $table->string('direction')->default('import');
            $table->string('status')->default('pending');

            $table->unsignedBigInteger('processed')->default(0);
            $table->unsignedBigInteger('created')->default(0);
            $table->unsignedBigInteger('updated')->default(0);
            $table->unsignedBigInteger('skipped')->default(0);
            $table->unsignedBigInteger('deleted')->default(0);
            $table->unsignedBigInteger('restored')->default(0);
            $table->unsignedBigInteger('errors')->default(0);

            $table->unsignedBigInteger('total')->nullable();
            $table->unsignedBigInteger('total_records')->nullable();

            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();

            $table->json('meta')->nullable();
            $table->text('error_message')->nullable();

            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            $table->timestamps();

            $table->index(['source', 'entity']);
            $table->index(['status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sync_runs');
    }
};
