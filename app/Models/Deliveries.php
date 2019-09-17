<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deliveries extends Model
{
    protected $fillable = [
        'name',
        'cost_per_km',
        'mass_koeff_kg',
    ];

    public function departments()
    {
        return $this->hasMany(Departments::class, 'delivery_id');
    }

    public function getDeliveriesByCity($cityId)
    {

        return $this->whereHas('departments', function ($subQuery) use ($cityId) {
            $subQuery->where('city_id', $cityId);
        })
            ->with([
                'departments' => function ($query) use ($cityId) {
                    $query->where('city_id', $cityId);
                }
            ]);
    }
}
