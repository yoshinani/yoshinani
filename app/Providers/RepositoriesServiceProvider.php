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
        $this->app->bind('Infrastructure\Repositories\AuthRepositoryInterface', 'Infrastructure\Repositories\AuthRepository');
        $this->app->bind('Infrastructure\Repositories\SocialRepositoryInterface', 'Infrastructure\Repositories\SocialRepository');
    }
}
