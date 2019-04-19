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

    protected $hidden = ['id', 'user_id', 'pivot'];
}
