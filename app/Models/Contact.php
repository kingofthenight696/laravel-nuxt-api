<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'email',
        'phone',
        'name',
        'city_id',
        'order_id',
        'cart_id',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function city()
    {
        return $this->belongsTo(Cities::class);
    }
}
