<?php
namespace App\Contracts;

use App\Models\Program;
use App\User;

interface ProgramContract
{
    public function create($organizationId, $displayName);

    public function all($organizationId);

    public function allWithLocation($organizationId);

    public function allWithUsers($organizationId);

    public function update(Program $program, $displayName);

    public function delete(Program $program);

    public function removeUser(User $user, Program $program);

    public function addUser($user_id, $program_id, $program_name);
}
