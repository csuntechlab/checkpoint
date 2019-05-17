<?php
namespace App\Contracts;

use App\Models\Program;

interface ProgramContract
{
    public function create($organizationId, $displayName);

    public function all($organizationId);

    public function update(Program $program, $displayName);

    public function delete(Program $program);
}
