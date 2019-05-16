<?php
namespace App\Contracts;

use App\Models\Project;

interface ProgramContract
{
    public function create($organizationId, $displayName);

    public function all($organizationId);

    public function update(Project $program, $displayName);

    public function delete(Project $program);
}
