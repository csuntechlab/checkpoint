<?php

use Illuminate\Database\Seeder;
use App\Models\TimeLog;

class ClockinSeeder extends Seeder
{
    public function run()
    {
        factory(Clockin::class, 200)->create();
    }
}