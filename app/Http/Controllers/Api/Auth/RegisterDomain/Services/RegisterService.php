<?php 
namespace App\Http\Controllers\Api\Auth\RegisterDomain\Services;

use App\User;
use Illuminate\Support\Facades\Hash;

use App\Http\Controllers\Api\UUIDGenerator\UUID;

use App\Http\Controllers\Api\Auth\RegisterDomain\Contracts\RegisterContract;


class RegisterService implements RegisterContract
{
    private $domainName = "user";

    public function register($request)
    {
        try {
            $name = (string)$request['name'];
            $email = (string)$request['email'];
            $password = (string)$request['password'];
        } catch (\Exception $e) {
            return ['message_error' => 'User was not successfully created.'];
        }

        $UUID = new UUID($this->domainName);

        try {
            $user = User::create([
                'id' => $UUID->toString,
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'user_profile' => 'place holder',
            ]);
        } catch (Illuminate\Database\QueryException $e) {
            return ['message_error' => 'User was not successfully created.'];
        }

        return $user;
    }
}
