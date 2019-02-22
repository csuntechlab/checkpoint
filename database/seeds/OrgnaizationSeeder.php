<?php

use Illuminate\Database\Seeder;
use App\Organization;

class OrgnaizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Organization::class)->create();
    }
}
