<?php

use Illuminate\Database\Seeder;

use Faker\Generator as Faker;
use App\DomainValueObjects\UUIDGenerator\UUID;


use App\User;
use App\Models\Project;
use App\Models\UserProject;
use App\Models\Organization;
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

            $project = $this->createProject($projectId, $organizationId, $faker);

            $users = User::where('organization_id', $organizationId)->get();
            
            $users = $users->shuffle();
            $users = $users->all();

            foreach ($users as $user) {
                $this->assignUsersToProjects($user, $project);
            }
        }
    }

    private function assignUsersToProjects($user, $project)
    {
        UserProject::create([
            'id' => UUID::generate(),
            'user_id' => $user->id,
            'project_id' => $project->id
        ]);
    }

    private function createProject($projectId, $organizationId, Faker $faker)
    {
        $name = $faker->unique()->name;
        $project = Project::create([
            'id' => $projectId,
            'organization_id' => $organizationId,
            'name' => $name,
            'display_name' => $name
        ]);

        return $project;
    }
}
