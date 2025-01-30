<?php

namespace App\Providers;

use App\Services\PlayStoreService;
use App\Services\AppleStoreService; // Import the AppleStoreService
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Register PlayStoreService
        $this->app->singleton(PlayStoreService::class, function ($app) {
            return new PlayStoreService();
        });

        // // Register AppleStoreService
        // $this->app->singleton(AppleStoreService::class, function ($app) {
        //     return new AppleStoreService();
        // });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
