<?php

namespace App\Providers\ApiProviders\TimeLog\Logic;

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
            'App\Http\Controllers\Api\TimeLog\Logic\Contracts\ClockInLogicContract',
            'App\Http\Controllers\Api\TimeLog\Logic\Services\ClockInLogicService'
        );
    }
}