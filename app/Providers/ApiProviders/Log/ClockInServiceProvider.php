<?php

namespace App\Providers\ApiProviders\Log;

use Illuminate\Support\ServiceProvider;

class ClockInServiceProvider extends ServiceProvider
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
            'App\Http\Controllers\Api\Log\ClockInDomain\Contracts\ClockInContract',
            'App\Http\Controllers\Api\Log\ClockInDomain\Services\ClockInService'
        );
    }
}
