<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CandidateRequest extends FormRequest
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
            'candidate_name' => 'nullable|string',
            'candidate_home_phone' => 'nullable|string',
            'candidate_email' => 'nullable|string',
            'passtypes_id' => 'nullable|integer',
            'candidate_nric' => 'nullable|string',
            'candidate_mobile' => 'nullable|string',
            'candidate_tel' => 'nullable|string',
            'candidate_birthdate' => 'nullable|date',
            'candidate_joindate' => 'nullable|date',
            'candidate_confirmationdate' => 'nullable|date',
            'candidate_tc_date' => 'nullable|date',
            'candidate_height' => 'nullable',
            'candidate_weight' => 'nullable',
            'candidate_type' => 'nullable|integer',
            'users_id' => 'nullable|exists:users,id',
            'leave_aprv1_users_id' => 'nullable|integer',
            'leave_aprv2_users_id' => 'nullable|integer',
            'leave_aprv3_users_id' => 'nullable|integer',
            'claims_aprv1_users_id' => 'nullable|integer',
            'claims_aprv2_id' => 'nullable|integer',
            'claims_aprv3_users_id' => 'nullable|integer',
            'candidate_n_level' => 'nullable|string',
            'candidate_o_level' => 'nullable|string',
            'candidate_a_level' => 'nullable|string',
            'candidate_diploma' => 'nullable|string',
            'candidate_degree' => 'nullable|string',
            'candidate_other' => 'nullable|string',
            'candidate_written' => 'nullable|string',
            'candidate_spocken' => 'nullable|string',
            'paymodes_id' => 'nullable|integer',
            'candidate_bank' => 'nullable|string',
            'candidate_bank_acc_no' => 'nullable|string',
            'candidate_bank_acc_title' => 'nullable|string',
            'candidate_street' => 'nullable|string',
            'candidate_unit_number' => 'nullable|string',
            'candidate_postal_code' => 'nullable|string',
            'candidate_street2' => 'nullable|string',
            'candidate_unit_number2' => 'nullable|string',
            'candidate_postal_code2' => 'nullable|string',
            'candidate_emr_contact' => 'nullable|string',
            'candidate_emr_relation' => 'nullable|string',
            'candidate_emr_phone1' => 'nullable|string',
            'candidate_emr_phone2' => 'nullable|string',
            'candidate_emr_address' => 'nullable|string',
            'candidate_emr_remarks' => 'nullable|string',
            'candidate_referee_name1' => 'nullable|string',
            'candidate_referee_occupation1' => 'nullable|string',
            'candidate_referee_year_know1' => 'nullable|string',
            'candidate_referee_contact1' => 'nullable|string',
            'candidate_referee_name2' => 'nullable|string',
            'candidate_referee_occupation2' => 'nullable|string',
            'candidate_referee_year_know2' => 'nullable|string',
            'candidate_referee_contact2' => 'nullable|string',
            'candidate_referee_present_employer' => 'integer',
            'candidate_referee_previous_employer' => 'integer',
            'candidate_dec_bankrupt' => 'integer',
            'candidate_dec_bankrupt_details' => 'string|nullable',
            'candidate_dec_physical' => 'integer',
            'candidate_dec_physical_details' => 'nullable|string',
            'candidate_dec_lt_medical' => 'nullable|integer',
            'candidate_dec_lt_medical_details' => 'nullable|string',
            'candidate_dec_law' => 'integer',
            'candidate_dec_law_details' => 'nullable',
            'candidate_dec_warning' => 'integer',
            'candidate_dec_warning_details' => 'nullable|string',
            'candidate_dec_applied' => 'integer',
            'candidate_dec_applied_dconsultant_idetails' => 'string|nullable',
            'races_id' => 'integer|nullable',
            'religions_id' => 'integer|nullable',
            'dbsexes_id' => 'integer|nullable',
            'marital_statuses_id' => 'integer|nullable',
            'clients_id' => 'integer|nullable',
            'jobs_id' => 'integer|nullable',
            'candidate_isBlocked' => 'nullable',
            'candidate_isDeleted' => 'integer',
            'children_no' => 'integer|nullable',
            'team_leader_id' => 'integer|nullable',
            'manager_id' => 'integer|nullable',
            'consultant_id' => 'integer|nullable',
            'avatar' => 'nullable|max:2048|mimes:jpg,jpeg,png,webp,gif,bmp,tiff,svg',

        ];
    }
}
