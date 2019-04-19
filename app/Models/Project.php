<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\UserProject;
use App\User;

class Project extends Model
{
    public $incrementing = false;
    public $timestamps = false;

    protected $hidden = ['location', 'id', 'organization_id', 'name', 'pivot'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_projects')->withPivot('id', 'user_id');
    }

    public function location()
    {
        // Model, fk, local
        return $this->hasMany(Location::class, 'id', 'id');
    }
}
