<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProject extends Model
{
    public $incrementing = false;
    public $timestamps = false;

    protected $table = 'user_projects';

    protected $fillable = ['id', 'user_id', 'project_id'];

    protected $hidden = ['id', 'user_id'];

    public function project()
    {
        // Model, fk, local
        return $this->belongsTo('App\Models\Project', 'project_id', 'id');
    }

    public function location()
    {
        // Model, fk, local
        return $this->hasMany('App\Models\location', 'id', 'project_id');
    }
}
