<?php

namespace App\Providers\ApiProviders\Log;

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
            'App\Http\Controllers\Api\Log\ClockOutDomain\Contracts\ClockOutContract',
            'App\Http\Controllers\Api\Log\ClockOutDomain\Services\ClockOutService'
        );
    }
}
