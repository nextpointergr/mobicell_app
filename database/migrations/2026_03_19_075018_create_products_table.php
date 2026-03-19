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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->nullable()
                ->comment('Δεν θα το χρησιμοποιήσουμε τώρα, αλλά είναι σημαντικό για SEO/URLs');
            $table->string('ean')->nullable();
            $table->string('mpn')->nullable();
            $table->integer('eshop_id')->nullable()
                ->comment('ID καταστήματος');
            $table->string('external_id')->nullable()
                ->comment('ID από εξωτερική πηγή (XML, ERP, API supplier)');
            $table->mediumText('description')->nullable()
                ->comment('Κύρια περιγραφή προϊόντος (HTML, μεγάλο κείμενο)');
            $table->text('short_description')->nullable()
                ->comment('Σύντομη περιγραφή προϊόντος');
            $table->string('meta_title')->nullable()
                ->comment('SEO title');
            $table->text('meta_description')->nullable()
                ->comment('SEO description');
            $table->text('meta_keywords')->nullable()
                ->comment('SEO keywords (comma separated)');
            $table->json('features')->nullable()
                ->comment('Χαρακτηριστικά προϊόντος σε JSON (attributes, specs από XML/API)');
            $table->boolean('active')->default(true);
            $table->string('status')->default('draft')->index();
            $table->string('hash')->nullable()->index();
            $table->timestamps();
            $table->index('name');
            $table->index('ean');
            $table->index('mpn');
            $table->index('eshop_id');
            $table->index(['eshop_id', 'ean']);
            $table->index(['eshop_id', 'mpn']);
            $table->fullText(['name', 'description', 'short_description']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
