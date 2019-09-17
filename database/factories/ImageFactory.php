<?php

use App\Models\Image;
use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Image::class, function (Faker $faker, $attrib) {
    return [
        'url' => 'https://placeimg.com/640/480/tech',
        'alt' => $faker->word,
        'product_id' => $attrib['product_id'],
    ];
});
