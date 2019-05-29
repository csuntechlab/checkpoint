<?php

use Illuminate\Database\Seeder;

use App\DomainValueObjects\UUIDGenerator\UUID;
use App\Models\TimeSheet;
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
        $startDate = Carbon::now('America/Los_angeles')->startOfMonth()->startOfDay();
        $endDate = Carbon::now('America/Los_angeles')->startOfDay();

        $endDate->addMonth()->endOfDay();

        TimeSheet::create([
            'id' => UUID::generate(),
            'organization_id' => $organization->id,
            'start_date' => $startDate,
            'end_date' => $endDate
        ]);
        

        // making another entry for the same organization at a different date
        
        $startDate = Carbon::now('America/Los_angeles')
        ->subMonths(1)
        ->startOfMonth()
        ->startOfDay();

        $endDate = Carbon::now('America/Los_angeles')
        ->subMonths(1)
        ->startOfDay();

        $endDate->addMonth()->endOfDay();

        TimeSheet::create([
            'id' => UUID::generate(),
            'organization_id' => $organization->id,
            'start_date' => $startDate,
            'end_date' => $endDate
        ]);
    }
}
