<?php
namespace App\Contracts;

interface ProgramContract
{
    public function create($organizationId, $name);

    public function all($organizationId);

    public function update($programId);

    public function delete($programId);
}
