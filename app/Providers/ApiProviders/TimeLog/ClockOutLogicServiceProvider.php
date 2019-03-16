<?php

namespace App\Providers\ApiProviders\TimeLog;

use Illuminate\Support\ServiceProvider;

class ClockOutLogicServiceProvider extends ServiceProvider
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
            'App\Http\Controllers\Api\TimeLog\ClockOutDomain\Contracts\ClockOutLogicContract',
            'App\Http\Controllers\Api\TimeLog\ClockOutDomain\Services\ClockOutLogicService'
        );
    }
}
