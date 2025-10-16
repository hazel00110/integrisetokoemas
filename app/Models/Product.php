<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Product model represents items available in the store.
 *
 * It maps to the `products` table which holds SKU, barcode, name, type,
 * karat, pricing per gram, making fee, notes and timestamps. This model
 * can be expanded with relationships to inventory lots or stock movements
 * in the future.
 */
class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sku',
        'barcode',
        'name',
        'type',
        'karat',
        'buy_price_per_gram',
        'sell_price_per_gram',
        'making_fee',
        'notes',
        'image_path',
    ];
}
