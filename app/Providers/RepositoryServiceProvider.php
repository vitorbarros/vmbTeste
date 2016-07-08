<?php
namespace VmbTest\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'VmbTest\Repositories\SintegraRepository',
            'VmbTest\Repositories\SintegraRepositoryEloquent'
        );

        $this->app->bind(
            'VmbTest\Repositories\UserRepository',
            'VmbTest\Repositories\UserRepositoryEloquent'
        );
    }
}
