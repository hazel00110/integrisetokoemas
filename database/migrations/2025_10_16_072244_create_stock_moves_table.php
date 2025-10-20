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
        Schema::create('stock_moves', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('store_id')->default(1); // kalau multi toko, nanti relasikan
            $table->foreignId('product_id')->constrained('products')->restrictOnDelete();
            $table->unsignedBigInteger('lot_id')->nullable(); // future-proof kalau pakai lots
            $table->enum('ref_type', ['in', 'sale', 'adjust']);
            $table->unsignedBigInteger('ref_id')->nullable(); // id order / penyesuaian
            $table->decimal('qty_gram_change', 15, 3)->default(0); // sale = negatif
            $table->integer('qty_pcs_change')->default(0);         // sale = negatif
            $table->string('note', 200)->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_moves');
    }
};
