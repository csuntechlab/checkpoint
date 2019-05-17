<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\User;
use App\Models\Location;
use App\Models\Program;


class UserProgram extends Model
{
    public $incrementing = false;
    public $timestamps = false;

    protected $table = 'user_programs';

    protected $fillable = ['id', 'user_id', 'program_id'];

    protected $hidden = ['id', 'user_id', 'pivot'];
}
