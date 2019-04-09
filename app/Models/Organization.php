<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'organizations';

    protected $hidden = [
        'id', 'address', 'updated_at', 'created_at'
    ];

    protected $guarded = [];
    public $incrementing = false;
}
