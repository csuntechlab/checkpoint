<?php

namespace App\Providers\ApiProviders\TimeLog\Repository;

use Illuminate\Support\ServiceProvider;

class TimeLogClockInRepositoryServiceProvider extends ServiceProvider
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
            'App\ModelRepositoryInterfaces\TimeLogClockInModelRepositoryInterface',
            'App\ModelRepositories\TimeLogClockInModelRepository'
        );
    }
}
