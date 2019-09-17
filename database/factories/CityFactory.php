<?php

use App\Models\Cities;
use Faker\Generator as Faker;

$factory->define(Cities::class, function (Faker $faker) {
    return [
        'name' =>  $faker->city,
    ];
});
