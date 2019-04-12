<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

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
        'email_verified_at', 'password', 'remember_token', 'id', 'updated_at', 'created_at', 'organization_id'
    ];


    protected $table = 'users';


    // public $incrementing = false;


    public function userRole()
    {
        // Model,fk,local
        return $this->hasOne('App\Models\UserRole', 'user_id', 'id');
    }


    public function userProject()
    {
        // Model, fk, local
        return $this->hasMany('App\Models\UserProject', 'user_id', 'id');
    }

    public function userLocation()
    {
        // Model, fk, local
        return $this->hasMany('App\Models\Location', 'id', 'organization_id');
    }
}
