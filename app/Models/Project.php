<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public $incrementing = false;
    public $timestamps = false;

    protected $hidden = ['id', 'organization_id', 'name'];
}
