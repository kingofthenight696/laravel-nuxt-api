<?php

use App\Models\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {

    $name = $faker->sentence(random_int(1, 3));
    $slug = str_slug($name, '-');

    return [
        'name' => $name,
        'slug' => $slug,
    ];
});
