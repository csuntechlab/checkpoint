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
            'App\Contracts\LoginContract',
            'App\Services\LoginService'
        );
    }
}
