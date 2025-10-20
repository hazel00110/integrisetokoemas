<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockMove extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'store_id',
        'product_id',
        'lot_id',
        'ref_type',
        'ref_id',
        'qty_gram_change',
        'qty_pcs_change',
        'note',
        'created_at',
    ];
}
