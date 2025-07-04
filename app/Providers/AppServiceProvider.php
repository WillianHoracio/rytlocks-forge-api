<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(\App\Services\ArenaNetServices\Gw2Validator::class);
        $this->app->singleton(\App\Services\ArenaNetServices\Gw2HttpClient::class);
        $this->app->singleton(\App\Services\ArenaNetServices\Gw2ItemService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
