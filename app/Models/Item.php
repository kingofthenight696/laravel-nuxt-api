<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{

    protected $fillable = [
        'order_id',
        'product_id',
        'price',
        'quantity',
        'preview',
        'title',
        'total_price',
        'created_at',
        'updated_at',
    ];

    public function carts()
    {
        return $this->belongsTo(Cart::class);
    }

    public function products()
    {
        return $this->belongsTo(Product::class);
    }

}
