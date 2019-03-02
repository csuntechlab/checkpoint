<?php

namespace App\Providers\ApiProviders\Log;

use Illuminate\Support\ServiceProvider;

class TimePuncherServiceProvider extends ServiceProvider
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
            'App\Http\Controllers\Api\Log\TimePuncher\Contracts\TimePuncherContract',
            'App\Http\Controllers\Api\Log\TimePuncher\Services\TimePuncherService'
        );
    }
}
