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
        Schema::create('stock_moves', function (Blueprint $t) {
            $t->id();
            $t->unsignedBigInteger('store_id')->default(1); // kalau multi toko, nanti relasikan
            $t->foreignId('product_id')->constrained('products')->restrictOnDelete();
            $t->unsignedBigInteger('lot_id')->nullable(); // future-proof kalau pakai lots
            $t->enum('ref_type', ['in', 'sale', 'adjust']);
            $t->unsignedBigInteger('ref_id')->nullable(); // id order / penyesuaian
            $t->decimal('qty_gram_change', 15, 3)->default(0); // sale = negatif
            $t->integer('qty_pcs_change')->default(0);         // sale = negatif
            $t->string('note', 200)->nullable();
            $t->timestamp('created_at')->useCurrent();
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
