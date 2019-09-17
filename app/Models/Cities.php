<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{
    protected $fillable = [
        'name',
    ];

    public function deliveries()
    {
        return $this->belongsToMany(Departments::class);
    }

    public function departments()
    {
        return $this->hasMany(Departments::class)->withPivot('price');
    }

}
