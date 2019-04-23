<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Contracts
use App\Contracts\AdminSettingsContract;

// Model Repository Interfaces
use App\ModelRepositoryInterfaces\PayPeriodTypeModelRepositoryInterface;

class AdminSettingsController extends Controller
{
    protected $adminSettingsUtility;
    protected $payPeriodModelRepo;

    public function __construct(AdminSettingsContract $adminSettingsContract, PayPeriodTypeModelRepositoryInterface $payPeriodTypeModelRepositoryInterface)
    {
        $this->adminSettingsUtility = $adminSettingsContract;
        $this->payPeriodModelRepo = $payPeriodTypeModelRepositoryInterface;
    }


    /**
     * The admin should only at this moment have three settings, 
     * 1. opt_in or out of categories 
     * 2. Pay Period type ... also set initial start and end date
     * 3. Set how you want to calculate time, but this should be the main focus of the next iteration.
     * 
     * The only special case:
     *      If organization settings pay_period_type is custom 
     *      we would need to have a start date and end date
     */


    public function setOrganizationSettings(Request $request)
    {
        $payPeriodType = $this->payPeriodModelRepo->getPayPeriodTypeById($request['payPeriodTypeId']);
        return $payPeriodType;

        // if ($this->payPeriodTypeIsCustom()) {
        //     dd('logic works')
        //     // set org settings 
        // }

        return $this->adminSettingsUtility->setOrganizationSettings(
            $request['categoriesOptIn'],
            $request['payPeriodTypeId'],
            $request['timeCalculatorTypeId'],
            $request['startDate']
        );
    }
}
