<?php

namespace App\Providers;

use App\Archivers\Archiver;
use App\Archivers\OrdersArchiver;
use App\Contracts\Application\Application;
use App\Contracts\Application\Setting;
use App\Models\PersonalAccessToken;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Sanctum\Sanctum;
use Tenant\Basic\App\BasicApplication;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(MacroServiceProvider::class);
        $this->app->register(LoggerServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
        Schema::defaultStringLength(191);

        $this->app->singleton(Setting::class, fn () => Setting::getInstance());
        $this->app->singleton(Application::class, function () {
            $tenant = Str::pascal(tenant("id"));

            $class = "Tenant\\$tenant\\App\\{$tenant}Application";

            if (class_exists($class)) {
                return new $class();
            }

            return new BasicApplication();
        });
        $this->app->singleton(Archiver::class, OrdersArchiver::class);
    }
}
