<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        // $this->call(PassportSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(OrgnaizationSeeder::class);
        $this->call(ProgramSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(TimeSheetSeeder::class);
        $this->call(TimeLogSeeder::class);
    }
}
