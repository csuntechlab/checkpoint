<?php

use Illuminate\Database\Seeder;
use App\Models\UserInvitation;

class UserInvitationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(UserInvitation::class, 50)->create();
    }
}
