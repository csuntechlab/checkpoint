<?php

use Illuminate\Database\Seeder;
use App\Models\TimeLog;

class TimeLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(TimeLog::class, 50)->create();
    }
}
