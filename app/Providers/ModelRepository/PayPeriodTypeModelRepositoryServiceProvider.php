<?php

namespace App\Providers\ModelRepository;

use Illuminate\Support\ServiceProvider;

class PayPeriodTypeModelRepositoryServiceProvider extends ServiceProvider
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
            'App\ModelRepositoryInterfaces\PayPeriodTypeModelRepositoryInterface',
            'App\ModelRepositories\PayPeriodTypeModelRepository'
        );
    }
}
