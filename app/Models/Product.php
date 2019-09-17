<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    public const PAGINATE_PER_PAGE = 4;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'displayed_price',
        'price',
        'weight',
        'preview',
        'seo_title',
        'seo_description',
        'is_exist',
        'views',
        'likes',
        'category_id',
        'owner_id',
        'created_at',
        'updated_at',
    ];

    protected $appends = ['avg_rating'];

    public function categories()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function owners()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class );
    }

    public function getAvgRatingAttribute()
    {
        return round($this->comments()->avg(DB::raw('rating')), 1);
    }
}
