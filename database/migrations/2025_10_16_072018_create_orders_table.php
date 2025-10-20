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
        Schema::create('orders', function (Blueprint $t) {
            $t->id(); // BIGINT
            $t->string('code', 30)->unique();     // e.g. POS-20251016-0001
            $t->string('customer_name', 120)->nullable();
            $t->decimal('subtotal', 15, 2)->default(0);
            $t->decimal('discount', 15, 2)->default(0);
            $t->decimal('tax', 15, 2)->default(0);
            $t->decimal('total', 15, 2)->default(0);
            $t->text('notes')->nullable();
            $t->enum('status', ['draft', 'paid', 'cancelled'])->default('paid');
            $t->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
