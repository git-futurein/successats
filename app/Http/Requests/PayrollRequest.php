<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PayrollRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'candidate_id' => 'required|integer',
            'job_type' => 'required|string',
            'admin_fee_monthly' => 'nullable|string',
            'client_company' => 'required|integer',
            'invoice_rate' => 'nullable|string',
            'daily_rate' => 'nullable|string',
            'job_title' => 'nullable|string',
            'department' => 'nullable|string',
            'wica' => 'nullable|string',
            'university' => 'nullable|string',
            'cost_center' => 'nullable|string',
            'working_hour' => 'nullable|string',
            'start_date' => 'required|string',
            'sales_period' => 'nullable|string',
            'invoice_no' => 'nullable|integer',
            'charge' => 'nullable|integer',
            'close_by1' => 'nullable|integer',
            'close_by2' => 'nullable|integer',
            'close_by3' => 'nullable|integer',
            'cut_off' => 'nullable|string',
            'recruitment_fee' => 'nullable|string',
            'admin_fee_daily' => 'nullable|string',
            'ar_no' => 'nullable|integer',
            'salary' => 'nullable|numeric',
            'daily_rate_night_shift' => 'nullable|string',
            'programme' => 'nullable|string',
            'hourly_rate' => 'nullable|string',
            'insurance_fee' => 'nullable|string',
            'team_lead' => 'nullable|string',
            'allowance' => 'nullable|string',
            'probation_period' => 'nullable|string',
            'end_date' => 'nullable|string',
            'guarantee_period' => 'nullable|string',
            'po_no' => 'nullable|string',
            'contribute_cpf' => 'nullable|string',
            'close_rate1' => 'nullable|integer',
            'close_rate2' => 'nullable|integer',
            'close_rate3' => 'nullable|integer',
            'payroll_remark' => 'nullable|string',
        ];
    }
}
