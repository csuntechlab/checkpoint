<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Contracts\AdminSettingsContract;

class AdminSettingsController extends Controller
{
    protected $adminSettingsUtility;

    public function __construct(AdminSettingsContract $adminSettingsContract)
    {
        $this->adminSettingsUtility = $adminSettingsContract;
    }


    /**
     * The admin should only at this moment have three settings, 
     * 1. opt_in or out of categories 
     * 2. Pay Period type ... also set initial start and end date
     * 3. Set how you want to calculate time, but this should be the main focus of the next iteration.
     */
    public function setOrganizationSettings()
    {
        return $this->adminSettingsUtility->setOrganizationSettings();
    }
}
