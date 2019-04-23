<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class OrganizationSettingsModelRepositoryServiceProvider extends ServiceProvider
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
            'App\ModelRepositoryInterfaces\OrganizationSettingModelRepositoryInterface',
            'App\ModelRepositories\OrganizationSettingsModelRepository'
        );
    }
}
