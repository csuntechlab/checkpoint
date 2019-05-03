<?php

namespace App\Providers\ApiProviders\Admin;

use Illuminate\Support\ServiceProvider;

class AdminSettingsProvider extends ServiceProvider
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
            'App\Contracts\AdminSettingsContract',
            'App\Services\AdminSettingsService'
        );
    }
}
