<?php
namespace App\Services;

// Domain Value Objects
use App\DomainValueObjects\UUIDGenerator\UUID;

//Models
use App\Models\Project;

//Exceptions

//Contracts
use App\Contracts\ProgramContract;


class ProgramService implements ProgramContract
{
    private function generateName($displayName)
    {
        $name = preg_replace("/[^a-z0-9_-\s]+/i", "", $displayName);
        $name = strtolower($name);
        return $name;
    }

    private function duplicate($name): bool
    {
        $duplicate = Project::where('name', $name)->first();
        dd($duplicate);
        $duplicate == null ? true : false;
        return $duplicate;
    }

    // TODO: THROW EXCEPTION
    // Check for duplicate
    public function create($organizationId, $displayName)
    {
        $name = $this->generateName($displayName);

        $projectId = UUID::generate();

        try {
            $project = Project::create([
                'id' => $projectId,
                'organization_id' => $organizationId,
                'name' => $name,
                'display_name' => $displayName,
            ]);
        } catch (\Exception $e) {
            // throw Model
            // dd($e);
            throw $e;
        }

        return $project;
    }

    public function all($organizationId)
    {
        try {
            return Project::with('location')->get();
            // return Project::all();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function update($program, $displayName)
    {
        $name = $this->generateName($displayName);

        return DB::transaction(function () use ($program, $displayName, $name) {
            try {
                $program->display_name = $displayName;
                $program->name = $name;
                $program->save();
            } catch (\Exception $e) {
                throw $e;
            }
            return $program;
        });
    }

    public function delete($program)
    {
        try {
            $program->delete();
        } catch (\Exception $e) {
            throw $e;
        }
        return ['message' => 'Program was deleted.'];
    }
}
