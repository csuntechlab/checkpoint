<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'name'];

    protected $table = 'roles';

    public $incrementing = false;
    public $timestamps = false;
}
