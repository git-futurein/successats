<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClientRequest extends FormRequest
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
        // $clientId = $this->route('client.edit') ? $this->route('client')->id : null;
        $clientId = $this->route('client.update') ? $this->route('client')->id : null;
        return [
            'client_name' => 'nullable',
            'industry_types_id' => 'nullable|integer',
            'client_attention_person' => 'nullable',
            'client_attention_designation' => 'nullable',
            'client_attention_phone' => 'nullable',
            'client_contact_person' => 'nullable',
            'client_contact_number' => 'nullable',
            'client_phone' => 'nullable|string',
            'client_fax' => 'nullable',
            'client_email' => 'email|required',
            'client_street' => 'nullable',
            'client_unit_number' => 'nullable',
            'client_postal_code' => 'nullable|numeric',
            'employees_id' => 'required|exists:employees,id',
            'users_id' => 'nullable|exists:users,id',
            'payroll_employees_id' => 'nullable|exists:employees,id',
            'payroll_users_id' => 'nullable|integer',
            'tnc_templates_id' => 'nullable|integer',
            'tnc_renewal_date' => 'nullable|date',
            'client_terms_id' => 'nullable|integer',
            'client_remarks' => 'nullable|string',
            'clients_seqno' => 'nullable|integer',
            'choices-single-no-sorting' => 'nullable',
            'client_website' => 'nullable',
        ];
    }
}
