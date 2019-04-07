<?php

namespace App\Providers\ApiProviders\TimeLog;

use Illuminate\Support\ServiceProvider;

class ClockOutServiceProvider extends ServiceProvider
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
            'App\Contracts\ClockOutContract',
            'App\Services\ClockOutService'
        );
    }
}
