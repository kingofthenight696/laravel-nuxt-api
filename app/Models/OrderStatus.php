<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    public const STATUS_ORDERED = 'Ordered';
    public const STATUS_SHIPPING = 'Shipping';
    public const STATUS_SHIPPED = 'Shipped';
    public const STATUS_CANCELED = 'Canceled';

    public const ORDER_STATUSES = [
        self::STATUS_ORDERED,
        self::STATUS_SHIPPING,
        self::STATUS_SHIPPED,
        self::STATUS_CANCELED,
    ];

    public $timestamps = false;
    protected $fillable = [
        'name'
    ];

    public function status()
    {
        return $this->hasMany(Order::class);
    }
}
