<?php

namespace App\Providers\ApiProviders\TimeLog;

use Illuminate\Support\ServiceProvider;

class ClockInLogicServiceProvider extends ServiceProvider
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
            'App\Http\Controllers\Api\TimeLog\ClockInDomain\Contracts\ClockInLogicContract',
            'App\Http\Controllers\Api\TimeLog\ClockInDomain\Services\ClockInLogicService'
        );
    }
}
