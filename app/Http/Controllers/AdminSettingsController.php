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
use App\Models\PayPeriodType;
use App\Models\TimeCalculatorType;

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
    public function createOrganizationSettings(
        AdminSettingsRequest $request,
        PayPeriodType $payPeriodType,
        TimeCalculatorType $timeCalculatorType
    ) {
        /** if the type is custom then we need a start and an end date */
        if ($payPeriodType->name == 'Custom' && !$request->has('endDate'))  return $this->noEndDateResponse();

        $admin = Auth::user();

        // Regardless of payPeriod Type an organization settings must be created
        return $this->adminSettingsUtility->createOrganizationSettings(
            $admin->organization_id,
            $request['categoriesOptIn'],
            $payPeriodType->id,
            $timeCalculatorType->id
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
