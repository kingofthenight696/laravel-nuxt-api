<?php

namespace App\Providers;

use App\Services\CartService;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(Request $request)
    {
        $this->app->bind('App\CartController', function () use ($request){

            return new CartService($request);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
