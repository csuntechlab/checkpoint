<?php

use Illuminate\Database\Seeder;
use App\Logs;

class LogsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Logs::class)->create();
    }
}
