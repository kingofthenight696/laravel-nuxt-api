<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Role::class, function (
    Faker $faker,
    $attrib = array(
        'name' => null,
    )
) {
    return [
        'name' => $attrib['name'],
    ];
});
