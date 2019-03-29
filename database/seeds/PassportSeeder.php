<?php

use Illuminate\Database\Seeder;

use App\Models\Passport\OauthClient;
use App\Models\Passport\OauthPersonalAccessClient;

class PassportSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createOathClientEntry(
            $user_id = null,
            $name = "Laravel Personal Access Client",
            $secret = "token",
            $redirect = "http://localhost",
            $personal_access_client = 1,
            $password_client = 0,
            $revoked = 0
        );
        $this->createOathClientEntry(
            $user_id = null,
            $name = "Laravel Password Grant Client",
            $secret = "token2",
            $redirect = "http://localhost",
            $personal_access_client = 0,
            $password_client = 1,
            $revoked = 0
        );

        $client_id = 1;
        OauthPersonalAccessClient::create([
            'client_id' => $client_id,
        ]);
    }

    private function createOathClientEntry($user_id, $name, $secret, $redirect, $personal_access_client, $password_client, $revoked)
    {
        OauthClient::create([
            'user_id' => $user_id,
            'name' => $name,
            'secret' => $secret,
            'redirect' => $redirect,
            'personal_access_client' => $personal_access_client,
            'password_client' => $password_client,
            'revoked' => $revoked,

        ]);
    }
}
