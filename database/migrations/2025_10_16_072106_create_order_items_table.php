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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')->restrictOnDelete();
            $table->integer('qty_pcs')->default(0);
            $table->decimal('qty_gram', 15, 3)->default(0); // presisi gram
            $table->decimal('price_per_gram', 15, 2)->nullable(); // snapshot harga jual/gram
            $table->decimal('making_fee', 15, 2)->default(0);      // per item/line
            $table->decimal('line_total', 15, 2)->default(0);      // subtotal per baris
            $table->text('notes')->nullable();
            $table->timestamps();
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
