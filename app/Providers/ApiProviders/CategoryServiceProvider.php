<?php

namespace App\Providers\ApiProviders;

use Illuminate\Support\ServiceProvider;

class CategoryServiceProvider extends ServiceProvider
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

    public function register()
    {
        $this->app->bind(
            'App\Contracts\CategoriesContract',
            'App\Services\CategoriesService'
        );
    }
}
