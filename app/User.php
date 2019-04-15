<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Models\Location;
use App\Models\UserRole;
use App\Models\UserProject;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'email', 'password', 'organization_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id',
        'email_verified_at', 'password', 'remember_token', 'id', 'updated_at', 'created_at', 'organization_id'
    ];

    protected $table = 'users';

    public function userRole()
    {
        return $this->hasOne(UserRole::class, 'user_id', 'id');
    }

    public function userProject()
    {
        return $this->hasMany(UserProject::class, 'user_id', 'id');
    }

    public function userLocation()
    {
        return $this->hasMany(Location::class, 'id', 'organization_id');
    }
}
