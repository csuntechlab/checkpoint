<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    public $incrementing = false;
    public $timestamps = false;

    protected $hidden = ['id', 'user_id', 'role_id'];

    public function role()
    {
        // Model, fk, local
        return $this->hasOne('App\Models\Role', 'id', 'role_id');
    }
}
