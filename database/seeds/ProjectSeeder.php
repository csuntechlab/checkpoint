<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Models\Project;
use App\Models\UserProject;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 0; $i < 30; $i++) {
            $projectId = UUID::generate();
            $organizationId = Organization::all()->random()->id;
            $userId = User::where('organization_id', $organizationId)->random()->id;
            $name = $faker->unique()->name;
            Project::create([
                'id' => $projectId,
                'organization_id' => $organizationId,
                'name' => $name,
                'display_name' => $name
            ]);

            UserProject::create([]);
        }
    }
}
