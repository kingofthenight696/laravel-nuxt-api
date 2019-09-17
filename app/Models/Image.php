<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'url',
        'alt',
        'product_id',
        'created_at',
        'updated_at',
    ];

    public function products()
    {
        return $this->belongsTo(Product::class);
    }

}
