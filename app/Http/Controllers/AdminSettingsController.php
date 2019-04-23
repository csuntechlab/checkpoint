<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Admin\AdminSettingsRequest;

// Auth
use Illuminate\Support\Facades\Auth;

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
     * 
     */
    public function createOrganizationSettings(AdminSettingsRequest $request)
    {
        $payPeriodName = $this->payPeriodModelRepo->getPayPeriodName($request['payPeriodTypeId']);

        /** if the type is custom then we need a start and an end date */
        if ($payPeriodName == 'Custom' && !$request->has('endDate'))  return $this->noEndDateResponse();

        $admin = Auth::user();
        $orgId = $admin->organization_id;

        // Regardless of payPeriod Type an organization settings must be created
        return $this->adminSettingsUtility->createOrganizationSettings(
            $orgId,
            $request['categoriesOptIn'],
            $request['payPeriodTypeId'],
            $request['timeCalculatorTypeId']
        );
    }

    private function noEndDateResponse()
    {
        $response =
            [
                "message" => "Custom type requires an End Date",
                "errors" => [
                    "endDate" => [
                        "End date is required!"
                    ]
                ]
            ];
        return $response;
    }
}
