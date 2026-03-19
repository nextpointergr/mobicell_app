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
        Schema::create('product_conflicts', function (Blueprint $table) {
            $table->id();
            $table->string('source')->index();
            $table->unsignedBigInteger('source_entity_id')->nullable()->index();
            $table->string('external_id')->index();
            $table->string('title')->nullable(); // <--- ΑΥΤΗ Η ΓΡΑΜΜΗ ΠΡΕΠΕΙ ΝΑ ΥΠΑΡΧΕΙ
            $table->string('conflict_type')->index();
            $table->json('payload')->nullable();
            $table->timestamps();
            $table->unique(['source', 'source_entity_id', 'external_id', 'conflict_type'], 'conflict_identity_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_conflicts');
    }
};
