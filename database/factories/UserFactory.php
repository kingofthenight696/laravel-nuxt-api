<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Role;
use App\Models\User;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker, $attrib) {

    $password = 11111111;
    return [
        'name' => $attrib['name'] ?? $faker->firstNameMale,
        'second_name' => $attrib['second_name'] ?? $faker->lastName,
        'role_id' => $attrib['role_id'] ?? Role::where('name', Role::USER_ROLE)->first()->id,
        'email' => $attrib['email'] ?? $faker->email,
        'gender' => $attrib['gender'] ?? 'male',
        'phone' => $attrib['phone'] ?? $faker->phoneNumber,
        'city' => $attrib['city'] ?? $faker->city,
        'street' => $attrib['street'] ?? $faker->streetName,
        'building_number' => $attrib['building_number'] ?? $faker->buildingNumber,
        'apartment_number' => $attrib['apartment_number'] ?? $faker->buildingNumber,
        'photo' => $attrib['photo'] ?? $faker->imageUrl($width = 640, $height = 480, 'cats', true, 'Faker'),
        'password' => $attrib['password'] ?? bcrypt($password),
    ];
});
