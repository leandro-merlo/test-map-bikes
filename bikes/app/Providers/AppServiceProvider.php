<?php

namespace App\Providers;

use App\Http\Services\IGeoLocationService;
use App\Http\Services\IPAPIGeolocationService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    // public $bindings = [
    //     IGeoLocationService::class => IPAPIGeolocationService::class
    // ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(IGeoLocationService::class, IPAPIGeolocationService::class);
    }
}
