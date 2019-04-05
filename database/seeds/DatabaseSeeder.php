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
        $this->call(TimeCalculatorTypeSeeder::class);
        $this->call(PayPeriodTypeSeeder::class);
        $this->call(OrganizationSeeder::class); //seeds org and settings
        $this->call(CategorySeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ProjectSeeder::class); // seeds also UserProject table
        $this->call(LocationSeeder::class);
        $this->call(UserInvitationsTableSeeder::class);
        // $this->call(ProgramSeeder::class);
        // $this->call(TimeSheetSeeder::class);
        // $this->call(TimeLogSeeder::class);
    }
}
