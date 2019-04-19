<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $hidden = ['id'];
}
