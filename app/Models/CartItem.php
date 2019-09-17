<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $appends = ['total_price'];

    protected $fillable = [
        'cart_id',
        'product_id',
        'price',
        'quantity',
        'preview',
        'title',
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

    public function getTotalPriceAttribute()
    {
        return $this->price * $this->quantity;
    }
}
