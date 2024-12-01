<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeaveRequest extends FormRequest
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
            'leave_approveds_id' => 'nullable|integer',
            'employees_id' => 'nullable|integer',
            'candidate_id' => 'nullable|integer',
            'leave_types_id' => 'nullable|integer',
            'leave_duration' => 'nullable|string',
            'leave_datefrom' => 'nullable|date',
            'leave_dateto' => 'nullable|date',
            'leave_total_day' => 'nullable',
            'leave_reason' => 'nullable|string',
            'leave_status' => 'nullable|integer',
            'leave_file_path' => 'nullable|mimes:pdf,jpeg,jpg,png|max:2048',
            'leave_empl_type' => 'nullable|string',
        ];
    }
}
