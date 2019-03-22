<?php
namespace App\Http\Controllers\Api\Auth\RegisterDomain\Services;

use Illuminate\Support\Facades\Hash;

//Models
use App\User;
use App\Models\Program;
use App\Models\UserInvitation;

//Exceptions
use App\Exceptions\AuthExceptions\UserCreatedFailed;

//Contracts
use App\Http\Controllers\Api\Auth\RegisterDomain\Contracts\RegisterContract;


class RegisterService implements RegisterContract
{
    public function register($name, $email, $password, $inviteCode): User
    {
        $programId  = $this->getPrgramIdByUserInvitation($email, $inviteCode);

        try {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'program_id' => $programId
            ]);
        } catch (\Exception $e) {
            throw new UserCreatedFailed();
        }

        return $user;
    }



    private function getPrgramIdByUserInvitation(string $email, string $inviteCode): string
    {
        $programId = UserInvitation::where('email', $email)->where('invite_code', $inviteCode)->first();

        //TODO HardCode
        $programId = Program::first();

        return $programId->id;
    }
}
