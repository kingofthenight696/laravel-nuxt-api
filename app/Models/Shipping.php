<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    protected $fillable = [
        'cart_id',
        'order_id',
        'delivery_id',
        'department_id',
        'price',
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function delivery()
    {
        return $this->belongsTo(Deliveries::class);
    }

    public function department()
    {
        return $this->belongsTo(Departments::class);
    }
}
