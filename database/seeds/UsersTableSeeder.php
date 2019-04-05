<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Models\Organization;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Tim Brumbough',
            'email' => 'Tim@email.com',
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm',
            'email_verified_at' => now(),
            'remember_token' => str_random(10),
            'organization_id' => Organization::all()->random()->id

        ]);
        factory(User::class, 100)->create();
    }
}
