<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $incrementing = false;
    public $timestamps = false;

    protected $hidden = [
        'organization_id',
        'name',
    ];

    protected $fillable = [
        'organization_id',
        'name',
        'id',
        'display_name'
    ];
}
