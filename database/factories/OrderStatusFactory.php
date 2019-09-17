<?php

use App\Models\OrderStatus;
use Faker\Generator as Faker;

$factory->define(OrderStatus::class, function (
    Faker $faker,
    $attrib = array(
        'name' => null,
    )
) {
    return [
        'name' => $attrib['name'],
    ];
});
