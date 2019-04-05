<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\DomainValueObjects\UUIDGenerator\UUID;


use App\User;
use App\Models\Organization;
use App\Models\Role;
use App\Models\UserRole;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $role = Role::where('name', 'Employee')->first();

        $user = User::create([
            'name' => 'Tim Brumbough',
            'email' => 'Tim@email.com',
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm',
            'email_verified_at' => now(),
            'remember_token' => str_random(10),
            'organization_id' => Organization::all()->random()->id

        ]);

        $this->assignRole($user, $role);

        for ($i = 0; $i < 100; $i++) {
            $user = User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->email,
                'email_verified_at' => now(),
                'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
                'remember_token' => str_random(10),
                'organization_id' => Organization::all()->random()->id
            ]);
            $this->assignRole($user, $role);
        }
    }

    private function assignRole($user, $role)
    {
        UserRole::create([
            'id' => UUID::generate(),
            'user_id' => $user->id,
            'role_id' => $role->id,
        ]);
    }
}
