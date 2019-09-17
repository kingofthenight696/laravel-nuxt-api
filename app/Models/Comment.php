<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public const PAGINATE_PER_PAGE = 3;

    protected $fillable = [
        'comment',
        'rating',
        'user_id',
        'product_id',
        'verified',
    ];

    protected $with = ['user'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function scopeVerified()
    {
        return $this->where('verified', true);
    }

    public function scopeNotVerified()
    {
        return $this->where('verified', false);
    }

}
