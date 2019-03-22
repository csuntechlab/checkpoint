<?php

use Illuminate\Database\Seeder;

class PassportSeeder extends Seeder
{

    private function getArray()
    { }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $id = 1;
        $user_id = null;
        $name = "Laravel Personal Access Client";
        $secret = "token";
        $redirect = "http://localhost";
        $personal_access_client = 1;
        $password_client = 0;
        $revoked = 0;
        $created_at = "2019-03-21 16:39:05";
        $updated_at = "2019-03-21 16:39:05";
        DB::insert('insert into oauth_clients (id, user_id, name, secret, redirect, personal_access_client, password_client, revoked, created_at, updated_at) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [$id, $user_id, $name, $secret, $redirect, $personal_access_client, $password_client, $revoked, $created_at, $updated_at]);

        $id = 2;
        $user_id = null;
        $name = "Laravel Password Grant Client";
        $secret = "token2";
        $redirect = "http://localhost";
        $personal_access_client = 0;
        $password_client = 1;
        $revoked = 0;
        $created_at = "2019-03-21 16:39:05";
        $updated_at = "2019-03-21 16:39:05";
        DB::insert('insert into oauth_clients (id, user_id, name, secret, redirect, personal_access_client, password_client, revoked, created_at, updated_at) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [$id, $user_id, $name, $secret, $redirect, $personal_access_client, $password_client, $revoked, $created_at, $updated_at]);

        $id = 1;
        $client_id = 1;
        $created_at = "2019-03-21 16:39:05";
        $updated_at = "2019-03-21 16:39:05";
        // DB::insert('insert into oauth_personal_access_clients (id, client_id, created_at, updated_at) values(?, ?, ?, ?)', [$id, $client_id, $created_at, $updated_at]);
    }
}
