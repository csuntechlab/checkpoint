<?php

namespace App\Models\Passport;

use Illuminate\Database\Eloquent\Model;

class OauthClient extends Model
{
    // Is filled when passport:install happens
    protected $table = 'oauth_clients';
}
