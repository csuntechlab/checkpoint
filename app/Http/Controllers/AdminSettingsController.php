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
    public function updateCategories(AdminSettingCategoriesRequest $request)
    {
        $organizationId  = (Auth::user())->organization_id;
        return $this->adminSettingsUtility->updateCategories($organizationId, $request['categoriesOptIn']);
    }

    public function updatePayPeriod(PayPeriodType $payPeriodType, AdminSettingPayPeriodRequest $request)
    {
        if ($payPeriodType->name == 'Custom' && !$request->has('endDate'))  return $this->noEndDateResponse();

        $this->authorize('isAdmin', User::class);

        $organizationId  = (Auth::user())->organization_id;

        return $this->adminSettingsUtility->updatePayPeriod($organizationId, $payPeriodType->id);
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
