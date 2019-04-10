<?php

namespace App\Providers\ApiProviders\Auth;

use Illuminate\Support\ServiceProvider;

class RegiserServiceProvider extends ServiceProvider
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
            'App\Contracts\RegisterContract',
            'App\Services\RegisterService'
        );
    }
}
