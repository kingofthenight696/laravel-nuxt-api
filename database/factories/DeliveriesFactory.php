<?php

use App\Models\Deliveries;
use Faker\Generator as Faker;

$factory->define(Deliveries::class, function (Faker $faker) {
    return [
        'name' =>  $faker->company,
        'cost_per_km' =>  $faker->randomFloat(2, 0.1, 0.6),
        'mass_koeff_kg' => $faker->randomFloat(2, 0, 1),
    ];
});
