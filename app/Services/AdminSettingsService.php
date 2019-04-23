<?php
namespace App\Services;

use App\Contracts\AdminSettingsContract;

class AdminSettingsService implements AdminSettingsContract
{
    public function setOrganizationSettings()
    {
        dd('helllo');
        return 'hello';
    }
}
