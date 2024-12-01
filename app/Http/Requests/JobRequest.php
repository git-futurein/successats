<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'job_title' => 'required|string',
            'job_category_id' => 'required|integer',
            'job_salary' => 'nullable|numeric',
            'remark' => 'nullable|string',
            'job_status' => 'nullable|boolean',
            'postal_code' => 'nullable|string',
            'address' => 'nullable|string',
            'co_owner_id' => 'nullable|integer',
            'client_id' => 'required|integer',
            'person_incharge' => 'required|integer',
            'co_owner_id' => 'required|integer',
            'job_type_id' => 'nullable|integer',
            'short_desc' => 'nullable|string',
            'job_added_date' => 'nullable|date',
            'display_address' => 'nullable|string',
            'job_link' => 'nullable|string',
            'description' => 'nullable|string',
            'meta_title' => 'nullable|string',
            'meta_tag' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'unit_no' => 'nullable|numeric',
            'job_link' => 'nullable|string',
        ];
    }
}
