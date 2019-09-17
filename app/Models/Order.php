<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{

    protected $appends = ['total_price', 'product_price', 'total_quantity', 'order_status'];

    protected $fillable = [
        'user_id',
        'status_id',
        'session',
        'created_at',
        'updated_at',
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        return $this->belongsTo(OrderStatus::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function contact()
    {
        return $this->hasOne(Contact::class);
    }

    public function shipping()
    {
        return $this->hasOne(Shipping::class);
    }

    public function fullShipment()
    {
        return $this->shipping()->with(['delivery', 'department']);
    }

    public function scopeBySession($session)
    {
        return $this->where('session', $session);
    }

    public function scopeByUser($userId)
    {
        return $this->whereUserId($userId);
    }

//    public function ($session, $userId)
//    {
//        $this->when()
//    }

    public function getLastOrder($userId)
    {
        return $this->byUserId($userId)->with('items')->last();
    }

    public function scopeByUserId($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function getProductPriceAttribute()
    {
        return $this->items()->sum(DB::raw('quantity * price'));
    }

    public function getTotalPriceAttribute()
    {
        return $this->product_price + $this->shipping()->first()->price;
    }

    public function getOrderStatusAttribute()
    {
        return $this->status()->first()->name;
    }

}
