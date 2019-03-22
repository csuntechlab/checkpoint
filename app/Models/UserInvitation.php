<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DirapeToken;

class UserInvitation extends Model
{
    protected $DT_Column='invite_code';
    protected $DT_settings=['type'=>DT_UniqueNum,'size'=>6,'special_chr'=>false];


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'organization_id', 'role_id', 'name', 'email', 'invite_code'
    ];
}
