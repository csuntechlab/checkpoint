<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

// Models
use App\Models\Role;
use App\Models\Location;
use App\Models\Program;

// Traits
use App\UserTraits\AuthorizationTrait;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, AuthorizationTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'organization_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        // 'id',
        'email_verified_at',
        'password',
        'remember_token',
        'updated_at',
        'created_at',
        'organization_id',
        'pivot'
    ];

    protected $table = 'users';

    public function userProgram()
    {
        return $this->belongsToMany(Program::class, 'user_programs', 'user_id', 'program_id');
    }

    public function userLocation()
    {
        return $this->hasMany(Location::class, 'id', 'organization_id');
    }

    public function role()
    {
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id');
    }
}
