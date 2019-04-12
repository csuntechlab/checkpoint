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
            'name' => 'Admin',
        ]);

        Role::create([
            'name' => 'Mentor',
        ]);

        Role::create([
            'name' => 'Employee',
        ]);
    }
}
