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
        $this->call(OrgnaizationSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(TimeSheetSeeder::class);
        // $this->call(LogsSeeder::class);
    }
}
