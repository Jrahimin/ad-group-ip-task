<?php

namespace App\Providers;

use App\Models\Ip;
use App\Observers\IpObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     * @return void
     */
    public function boot()
    {
        Ip::observe(IpObserver::class);
    }
}
