<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DirapeToken;

class UserInvitation extends Model
{
    protected $DT_Column='token';
    protected $DT_settings=['type'=>DT_UniqueNum,'size'=>6,'special_chr'=>false];
}
