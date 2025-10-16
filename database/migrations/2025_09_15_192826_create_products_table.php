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
            $table->string('sku', 50)->unique();
            $table->string('barcode', 100)->nullable()->unique();
            $table->string('name', 150);
            // The type of product, matching the CodeIgniter enum of perhiasan, batangan, and lain
            $table->enum('type', ['perhiasan', 'batangan', 'lain']);
            $table->decimal('karat', 5, 2)->nullable();
            $table->decimal('buy_price_per_gram', 15, 2)->nullable();
            $table->decimal('sell_price_per_gram', 15, 2)->nullable();
            $table->decimal('making_fee', 15, 2)->default('0.00');
            $table->text('notes')->nullable();
            $table->timestamps();
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