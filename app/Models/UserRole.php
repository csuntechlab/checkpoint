<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Role;

class UserRole extends Model
{
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ['id', 'user_id', 'role_id'];
    protected $hidden = ['id', 'user_id', 'role_id'];

    public function role()
    {
        // Model, fk, local
        return $this->hasOne(Role::class, 'id', 'role_id');
    }

    public function roleMentor()
    {
        return $this->hasOne(Role::class, 'id', 'role_id')
            ->whereHas('name',  function ($query) {
                $query->where('name', 'Mentor');
            });
        // return $this->hasOne(Role::class, 'id', 'role_id');
    }
}
