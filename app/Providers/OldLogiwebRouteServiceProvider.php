<?php

namespace App\Providers;

use Illuminate\Routing\Route;
use Illuminate\Support\ServiceProvider;

class OldLogiwebRouteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Route::macro("logiwebResource", function (string $name, string $class, array $only = [], array $except = []) {
            return \Illuminate\Support\Facades\Route::apiResource($name, $class)
                ->only($only)
                ->except(array_merge($except, ['show']));
        });
    }
}
