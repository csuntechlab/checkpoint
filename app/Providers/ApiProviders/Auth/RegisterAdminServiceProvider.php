<?php

namespace App\Providers\ApiProviders\Auth;

use Illuminate\Support\ServiceProvider;

class RegiserAdminServiceProvider extends ServiceProvider
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
            'App\Http\Controllers\Api\Auth\RegisterDomain\Contracts\RegisterAdminContract',
            'App\Http\Controllers\Api\Auth\RegisterDomain\Services\RegisterAdminService'
        );
    }
}
