<?php

namespace App\Providers;

use App\Contracts\Repositories\IpRepositoryInterface;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Repositories\IpRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(IpRepositoryInterface::class, IpRepository::class);
    }

    /**
     * Bootstrap services.
     * @return void
     */
    public function boot()
    {
        //
    }
}
