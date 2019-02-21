<?php 
namespace App\Http\Controllers\Api\Auth\RegisterDomain\Services;

use App\User;
use Illuminate\Support\Facades\Hash;

use App\Http\Controllers\Api\Auth\RegisterDomain\Contracts\RegisterContract;

use App\Http\Controllers\Api\UUIDGenerator\UUIDGenerator as UUIDGenerator;

class RegisterService implements RegisterContract
{
    private $name_of_domain = "user";

    public function register($request)
    {
        try {
            $name = (string)$request['name'];
            $email = (string)$request['email'];
            $password = (string)$request['password'];
        } catch (\Exception $e) {
            return ['message_error' => 'User was not successfully created.'];
        }

        $uuid = UUIDGenerator::generate_uuid_5($this->name_of_domain);

        try {
            $user = User::create([
                'id' => $uuid,
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
            ]);
        } catch (Illuminate\Database\QueryException $e) {
            return ['message_error' => 'User was not successfully created.'];
        }

        return $user;
    }
}
