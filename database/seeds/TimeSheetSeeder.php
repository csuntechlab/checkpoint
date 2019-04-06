<?php

use Illuminate\Database\Seeder;

use App\DomainValueObjects\UUIDGenerator\UUID;
use App\Models\TimeSheets;
use App\Models\Organization;
use Carbon\Carbon;

class TimeSheetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $organizations = Organization::all();

        foreach ($organizations as $organization) {
            $this->createTimeSheet($organization);
        }
    }

    private function createTimeSheet($organization)
    {
        $startDate = Carbon::now('America/Los_Angeles')->startOfMonth()->startOfDay();
        $endDate = Carbon::now('America/Los_Angeles')->startOfDay();

        $endDate->addMonth()->endOfDay();

        TimeSheets::create([
            'id' => UUID::generate(),
            'organization_id' => $organization->id,
            'start_date' => $startDate,
            'end_date' => $endDate
        ]);
    }
}
