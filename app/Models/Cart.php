<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cart extends Model
{

    protected $appends = ['total_price', 'product_price', 'total_quantity'];

    protected $fillable = [
        'user_id',
        'session',
        'created_at',
        'updated_at',
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function shipping()
    {
        return $this->hasOne(Shipping::class);
    }

    public function contact()
    {
        return $this->hasOne(Contact::class);
    }

    public function getCartBySession($sessionId)
    {
        return Cart::bySession($sessionId)->first();
    }

    public function getCartItemsBySession($sessionId)
    {
        return CartItem::whereHas('cart', function ($query) use ($sessionId) {
            return $query->where('session', $sessionId);
        });
    }

    public function getCartItemsByUser($userId)
    {
        return CartItem::whereHas('cart', function ($query) use ($userId) {
            return $query->where('user_id', $userId);
        });
    }

    public function getCartByUserOrSession(int $user_id = null, string $session_id)
    {
        return Cart::when($user_id, function ($query) use ($user_id) {
            return $query->where('user_id', $user_id);
        })->orWhere('session', $session_id)->with([
            'cartItems',
            'contact',
            'shipping'
        ]);
    }

    public function getCartByUser($user_id)
    {
        return Cart::byUserId($user_id)->first();
    }

    public function scopeBySession($query, $sessionId)
    {
        return $query->where('session', $sessionId);
    }

    public function scopeByUserId($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function getProductPriceAttribute()
    {
        return $this->cartItems()->sum(DB::raw('quantity * price'));
    }

    public function getTotalPriceAttribute()
    {
        return $this->product_price + ($this->shipping()->first()->price ?? 0);
    }

    public function getTotalQuantityAttribute()
    {
        return $this->cartItems()->sum(DB::raw('quantity'));
    }
}
