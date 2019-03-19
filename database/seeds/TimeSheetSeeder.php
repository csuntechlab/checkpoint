<?php

use Illuminate\Database\Seeder;
use App\Models\TimeSheets;

class TimeSheetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(TimeSheets::class)->create();
    }
}
