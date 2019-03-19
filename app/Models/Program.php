<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    public $incrementing = false;
    protected $fillable = ['id', 'organization_id', 'program_name'];
}
