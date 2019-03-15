<?php

namespace App\Providers\ApiProviders\TimeLog;

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
            'App\Http\Controllers\Api\TimeLog\TimePuncher\Contracts\TimePuncherContract',
            'App\Http\Controllers\Api\TimeLog\TimePuncher\Services\TimePuncherService'
        );
    }
}
