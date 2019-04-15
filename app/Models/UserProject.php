<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\User;
use App\Models\Location;
use App\Models\Project;


class UserProject extends Model
{
    public $incrementing = false;
    public $timestamps = false;

    protected $table = 'user_projects';

    protected $fillable = ['id', 'user_id', 'project_id'];

    // protected $hidden = ['id'];
    protected $hidden = ['id', 'user_id'];

    public function project()
    {
        // Model, fk, local
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    public function location()
    {
        // Model, fk, local
        return $this->hasMany(Location::class, 'id', 'project_id');
    }

    public function mentorsProject()
    {
        return $this->hasMany(self::class, 'project_id', 'project_id');
    }

    // public function mentorProfile()
    // {
    // return $this->hasOne(User::class, 'id', 'user_id')->with('userRole.roleMentor');
    // }

    public function mentorProfile()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
