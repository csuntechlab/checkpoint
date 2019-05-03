<?php

use Illuminate\Database\Seeder;

use App\Models\TimeCalculatorType;
use App\DomainValueObjects\UUIDGenerator\UUID;

class TimeCalculatorTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = 'META+LAB';
        $this->createType($name);

        $name = 'Build Poder';
        $this->createType($name);
    }

    private function createType($name)
    {
        $id = UUID::generate();
        TimeCalculatorType::create([
            'id' => $id,
            'name' => $name,
        ]);
    }
}
