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
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Infrastructure\Interfaces\Auth\ManualRepositoryInterface', 'Infrastructure\Repositories\Auth\ManualRepository');
        $this->app->bind('Infrastructure\Interfaces\Auth\SocialRepositoryInterface', 'Infrastructure\Repositories\Auth\SocialRepository');
    }
}
