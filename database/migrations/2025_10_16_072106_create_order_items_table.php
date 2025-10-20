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
        Schema::create('order_items', function (Blueprint $t) {
            $t->id();
            $t->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $t->foreignId('product_id')->constrained('products')->restrictOnDelete();
            $t->integer('qty_pcs')->default(0);
            $t->decimal('qty_gram', 15, 3)->default(0); // presisi gram
            $t->decimal('price_per_gram', 15, 2)->nullable(); // snapshot harga jual/gram
            $t->decimal('making_fee', 15, 2)->default(0);      // per item/line
            $t->decimal('line_total', 15, 2)->default(0);      // subtotal per baris
            $t->text('notes')->nullable();
            $t->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
