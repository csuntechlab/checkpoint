<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Requests
use App\Http\Requests\Admin\AdminSettingCategoriesRequest;
use App\Http\Requests\Admin\AdminSettingPayPeriodRequest;

// Auth
use Illuminate\Support\Facades\Auth;

// Contracts
use App\Contracts\AdminSettingsContract;

// Model Repository Interfaces
use App\ModelRepositoryInterfaces\PayPeriodTypeModelRepositoryInterface;
use App\Models\PayPeriodType;
use App\Models\TimeCalculatorType;
use App\User;


class AdminSettingsController extends Controller
{
    protected $adminSettingsUtility;

    public function __construct(AdminSettingsContract $adminSettingsContract)
    {
        $this->adminSettingsUtility = $adminSettingsContract;
    }

    /**
     * Return current state of Organization Settings 
     * AND return all() Pay Period , time calc(NEXT ITERATION)
     * */
    public function currentOrganizationSettings()
    {
        $organizationId  = (Auth::user())->organization_id;
        return $this->adminSettingsUtility->currentOrganizationSettings($organizationId);
    }

    /**
     * The admin should only at this moment have three settings, 
     * 1. opt_in or out of categories 
     * 2. Pay Period type ... also set initial start and end date
     * 3. Set how you want to calculate time, but this should be the main focus of the next iteration.
     * 
     * The only special case:
     *      If organization settings pay_period_type is custom 
     *      we would need to have a start date AND end date
     * 
     */
    public function updateCategoriesOptIn(AdminSettingCategoriesRequest $request)
    {
        dd($request);
    }

    public function updatePayPeriod(AdminSettingPayPeriodRequest $request, PayPeriodType $payPeriodType)
    {
        dd($request);
        if ($payPeriodType->name == 'Custom' && !$request->has('endDate'))  return $this->noEndDateResponse();

        $organizationId  = (Auth::user())->organization_id;

        $this->authorize('isAdmin', User::class);
        dd('Hellro');
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
