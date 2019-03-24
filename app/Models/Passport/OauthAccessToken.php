<?php

namespace App\Models\Passport;

use Illuminate\Database\Eloquent\Model;

class OauthAccessToken extends Model
{
    // tokens are created here for users
    protected $table = 'oauth_access_tokens';
}
