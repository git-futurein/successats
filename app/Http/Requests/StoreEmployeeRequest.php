<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
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
            'reg_no' => 'nullable|string',
            'employee_outlet_id' => 'integer',
            'employee_code' => 'nullable',
            'employee_name' => 'nullable',
            'employee_phone' => 'nullable',
            'passtypes_id' => 'nullable',
            'employee_nric' => 'nullable',
            'employee_mobile' => 'nullable',
            'employee_tel' => 'nullable',
            'employee_birthdate' => 'date|nullable',
            'employee_joindate' => 'date|nullable',
            'employee_confirmationdate' => 'date|nullable',
            'employee_prdate' => 'date|nullable',
            'employee_resigndate' => 'date|nullable',
            'employee_resignreason' => 'nullable',
            'employee_numberofchildren' => 'integer|nullable',
            'users_id' => 'integer|nullable',
            'manager_users_id' => 'integer|nullable',
            'team_leader_users_id' => 'integer|nullable',
            'employee_shrc' => 'string|nullable',
            'employee_defination' => 'string|nullable',
            'leave_aprv1_users_id' => 'integer|nullable',
            'leave_aprv2_users_id' => 'integer|nullable',
            'leave_aprv3_users_id' => 'integer|nullable',
            'claims_aprv1_users_id' => 'integer|nullable',
            'claims_aprv2_id' => 'integer|nullable',
            'claims_aprv3_users_id' => 'integer|nullable',
            'is_payroll_enable' => 'integer',
            'is_cpf_enable' => 'integer',
            'employee_isovertime' => 'integer',
            'paymodes_id' => 'integer|nullable',
            'employee_bank' => 'nullable',
            'employee_bank_acc_no' => 'nullable',
            'employee_bank_acc_title' => 'nullable',
            'employee_street' => 'nullable',
            'employee_unit_number' => 'nullable',
            'employee_postal_code' => 'nullable',
            'employee_street2' => 'nullable',
            'employee_unit_number2' => 'nullable',
            'employee_postal_code2' => 'nullable',
            'employee_emr_contact' => 'nullable',
            'employee_emr_relation' => 'nullable',
            'employee_emr_phone1' => 'nullable',
            'employee_emr_phone2' => 'nullable',
            'employee_emr_address' => 'nullable',
            'employee_emr_remarks' => 'nullable',
            'departments_id' => 'integer|nullable',
            'designations_id' => 'integer|nullable',
            'employee_work_time_start' => 'string|nullable',
            'employee_work_time_end' => 'string|nullable',
            'employee_probation' => 'integer|nullable',
            'employee_extentionprobation' => 'integer|nullable',
            'employee_fw_permit_number' => 'string|nullable',
            'employee_fw_application_date' => 'nullable|date',
            'employee_fw_issue_date' => 'nullable|date',
            'employee_fw_arrival_date' => 'nullable|date',
            'employee_fw_renewal_date' => 'nullable|date',
            'races_id' => 'nullable|integer',
            'religions_id' => 'nullable|integer',
            'dbsexes_id' => 'nullable|integer',
            'marital_statuses_id' => 'nullable|integer',
            'clients_id' => 'nullable|integer',
            'employee_status' => 'integer',
            'employee_isDeleted' => 'integer',
            'employee_avater' => 'nullable',
            'employee_fw_levy_amount' => 'nullable|numeric',
        ];
    }
}
