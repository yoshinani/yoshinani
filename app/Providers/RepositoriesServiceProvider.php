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
        $this->app->bind('Infrastructure\Interfaces\ManualRepositoryInterface', 'Infrastructure\Repositories\ManualRepository');
        $this->app->bind('Infrastructure\Interfaces\SocialRepositoryInterface', 'Infrastructure\Repositories\SocialRepository');
    }
}
