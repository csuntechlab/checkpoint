<?php

namespace App\Http\Controllers;

// Request
use App\Http\Requests\ProgramRequest;
use App\Http\Requests\ProgramUserRequest;
use App\Http\Requests\DisplayNameRequest;

// Auth
use Illuminate\Support\Facades\Auth;
// Models
use App\Models\Program;
use App\User;
// Contracts
use App\Contracts\ProgramContract;

class ProgramController extends Controller
{
    private $programUtility;
    public function __construct(ProgramContract $programContract)
    {
        $this->programUtility = $programContract;
    }

    public function all()
    {
        $user = Auth::user();
        $organizationId = $user->getOrganizationIdAuthorizeAdmin();
        return $this->programUtility->all($organizationId);
    }

    public function allWithLocation()
    {
        $user = Auth::user();
        $organizationId = $user->organization_id;
        return $this->programUtility->allWithLocation($organizationId);
    }

    public function allWithUsers()
    {
        $user = Auth::user();
        $organizationId = $user->organization_id;
        return $this->programUtility->allWithUsers($organizationId);
    }

    public function create(ProgramRequest $request)
    {
        $user = Auth::user();
        $organizationId = $user->getOrganizationIdAuthorizeAdmin();
        return $this->programUtility->create($organizationId, $request['display_name']);
    }

    public function update(DisplayNameRequest $request, Program $program)
    {
        $user = Auth::user();
        $user->getOrganizationIdAuthorizeAdmin();
        $user->authorizeProgram($program);
        return $this->programUtility->update($program, $request['display_name']);
    }

    public function delete(Program $program)
    {
        $user = Auth::user();
        $user->getOrganizationIdAuthorizeAdmin();
        $user->authorizeProgram($program);
        return $this->programUtility->delete($program);
    }

    public function removeUser(User $user, Program $program)
    {
        return $this->programUtility->removeUser($user,$program);
    }

    public function addUser(ProgramUserRequest $request)
    {
        return $this->programUtility->addUser($request['user_id'], $request['program_id'], $request['program_name']);
    }
}
