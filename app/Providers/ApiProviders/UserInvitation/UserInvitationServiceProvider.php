<?php

namespace App\Providers\ApiProviders\UserInvitation;

use Illuminate\Support\ServiceProvider;

class UserInvitationServiceProvider extends ServiceProvider
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
            'App\Http\Controllers\Api\UserInvitation\Contracts\UserInvitationContract',
            'App\Http\Controllers\Api\UserInvitation\Services\userInvitationService'
        );
    }
}
