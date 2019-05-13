<?php

namespace App\Providers\ModelRepository;

use Illuminate\Support\ServiceProvider;

class UserModelRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\ModelRepositoryInterfaces\UserModelRepositoryInterface',
            'App\ModelRepositories\UserModelRepository'
        );
    }
}
