<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Distance extends Model
{
    protected $fillable = [
        'city_from',
        'city_to',
        'distance',
    ];

    public function delivery()
    {
        return $this->belongsTo(Deliveries::class);
    }
}
