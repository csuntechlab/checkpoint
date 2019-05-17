<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\User;

class Program extends Model
{
    public $incrementing = false;
    public $timestamps = false;

    protected $hidden = [
        'organization_id',
        'name',
        'pivot'
    ];
    protected $fillable = [
        'organization_id',
        'name',
        'id',
        'display_name'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_programs')->withPivot('id', 'user_id');
    }

    public function location()
    {
        // Model, fk, local
        return $this->hasMany(Location::class, 'id', 'id');
    }
}
