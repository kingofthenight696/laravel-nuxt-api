<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['sessions', 'cors', 'jwt.check']], function () {

    Route::group(['prefix' => '/auth', ['middleware' => 'throttle:20.5']], function () {
        Route::post('/register', 'Auth\RegisterController@register');
        Route::post('/login', 'Auth\LoginController@login');
    });

    Route::group(['middleware' => ['jwt.auth']], function () {
        Route::get('/logout', 'Auth\LogoutController@logout');
        Route::get('/me', 'UserController@me');
    });

    Route::get('categories', 'CategoryController@index');

    Route::get('products', 'ProductController@index');
    Route::get('products/{slug}', 'ProductController@show');


    Route::get('cart', 'CartController@index');
    Route::post('cart', 'CartController@store');
    Route::put('cart', 'CartController@update');
    Route::delete('cart/{productId}', 'CartController@removeCartItem');
    Route::put('cart/delivery', 'CartController@setDelivery');
    Route::put('cart/department', 'CartController@setDepartment');
    Route::put('cart/contact', 'CartController@setContacts');
    Route::put('buy', 'CartController@buy');

    Route::get('orders', 'OrderController@index');

    Route::get('deliveries-departments', 'DeliveryController@getDeliveryDepartment');
    Route::post('is-email-exist', 'UserController@isEmailExist');
    Route::get('cities', 'CityController@getCities');
    Route::post('comments', 'CommentController@store');
    Route::get('comments', 'CommentController@index');
});

