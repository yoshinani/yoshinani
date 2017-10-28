<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoriesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Repositories\AuthRepositoryInterface', 'App\Repositories\AuthRepository');
        $this->app->bind('App\Repositories\SocialRepositoryInterface', 'App\Repositories\SocialRepository');
    }
}
