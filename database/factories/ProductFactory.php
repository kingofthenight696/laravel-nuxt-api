<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker, $attrib) {

    $title = $faker->sentence(random_int(2, 10));
    $slug = str_slug($title, '-');

    return [
        'title' => $title,
        'slug' => $slug,
        'description' => $faker->paragraph(random_int(2, 10)),
        'displayed_price' => random_int(50, 99999),
        'price' => random_int(50, 99999),
        'weight' => $faker->randomFloat(2, 0, 10),
        'preview' => 'https://placeimg.com/640/480/tech',
        'seo_title' => 'ceo_' . $faker->sentence(random_int(3, 5)),
        'seo_description' => 'ceo_' . $faker->paragraph(random_int(2, 10)),
        'is_exist' => true,
        'views' => 0,
        'likes' => 0,
        'category_id' => $attrib['owner_id'],
        'owner_id' => $attrib['owner_id'] ?? User::adminRole()->first()->id,
    ];
});
