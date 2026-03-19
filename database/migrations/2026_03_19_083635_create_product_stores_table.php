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
        Schema::create('product_stores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('store_id');
            $table->string('erp_id')->nullable()
                ->comment('ERP ID προϊόντος για το συγκεκριμένο κατάστημα');
            $table->integer('stock')->default(0)
                ->comment('Απόθεμα ανά κατάστημα');
            $table->decimal('price', 10, 2)->nullable()
                ->comment('Τιμή ανά κατάστημα');
            $table->timestamps();
            $table->unique(['product_id', 'store_id']);
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_stores');
    }
};
