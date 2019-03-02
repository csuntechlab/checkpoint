<?php

namespace App\Providers\ApiProviders\Auth;

use Illuminate\Support\ServiceProvider;

class LoginServiceProvider extends ServiceProvider
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
            'App\Http\Controllers\Api\Auth\LoginDomain\Contracts\LoginContract',
            'App\Http\Controllers\Api\Auth\LoginDomain\Services\LoginService'
        );
    }
}
