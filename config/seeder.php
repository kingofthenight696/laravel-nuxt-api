<?php

return [

    'categories_first_step_quantity' => 10,
    'categories_second_step_quantity' => 5,
    'categories_third_step_quantity' => 5,

    'products_by_category_from' => 1,
    'products_by_category_to' => 15,

    'images_by_product_from' => 1,
    'images_by_product__to' => 5,


    'default' => env('QUEUE_CONNECTION', 'sync'),
];