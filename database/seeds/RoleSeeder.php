<?php

use Illuminate\Database\Seeder;

use App\Models\Role;
use App\DomainValueObjects\UUIDGenerator\UUID;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'id' => UUID::generate(),
            'name' => 'Admin',
            'display_name' => 'Admin',
        ]);

        Role::create([
            'id' => UUID::generate(),
            'name' => 'Supervisor',
            'display_name' => 'Supervisor',
        ]);

        Role::create([
            'id' => UUID::generate(),
            'name' => 'Employee',
            'display_name' => 'Employee',
        ]);
    }
}
