<?php

use App\Models\Comment;
use App\Models\Product;
use App\Models\User;
use Faker\Generator as Faker;


$factory->define(Comment::class, function (Faker $faker, $attrib) {

    $users = User::userRole()->get(['id']);
    return [
        'comment' =>  $faker->paragraph(random_int(2, 10)),
        'rating' => random_int(2, 5),
        'user_id' => $users->random()->id,
        'product_id' => $attrib['product_id'],
        'verified' => true,
    ];
});
