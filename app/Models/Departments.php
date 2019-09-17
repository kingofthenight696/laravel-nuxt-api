<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departments extends Model
{
    protected $appends = ['full_address'];
    protected $fillable = [
        'number',
        'city_id',
        'delivery_id',
        'address',
        'working_time',
        'phone',
    ];

    public function city()
    {
        return $this->belongsTo(Cities::class);
    }

    public function delivery()
    {
        return $this->belongsTo(Deliveries::class);
    }

    public function setWorkingTimeAttribute($value)
    {
        $this->attributes['working_time'] = json_encode($value);
    }

    public function getWorkingTimeAttribute($value)
    {
        return json_decode($value);
    }

    public function getFullAddressAttribute()
    {
        $address = json_decode($this->address, true);
        return implode(  ', ', $address);
    }
}

