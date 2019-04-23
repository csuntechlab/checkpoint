<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminSettingsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'startDate' => 'required|Date',
            'endDate' => 'Date',
            'categoriesOptIn' => 'required|bool',
            'payPeriodTypeId' => 'required|exists:pay_period_types,id',
            'timeCalculatorTypeId' => 'required|exists:time_calculator_types,id',
        ];
    }

    public function messages()
    {
        return [
            'startDate.required' => 'Start date is required!',
            'categoriesOptIn.required' => 'Categories is required!',
            'payPeriodTypeId.required' => 'Pay Period Type is required!',
            'timeCalculatorTypeId.required' => 'Time Calculator Type is required!',
        ];
    }
}
