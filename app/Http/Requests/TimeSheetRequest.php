<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TimeSheetRequest extends FormRequest
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
            'user_id' => 'required|integer',
            'title' => 'required|string',
            'print' => 'nullable|string',
            'remark' => 'nullable',
            'sunday_in' => 'nullable|timezone',
            'sunday_out' => 'nullable|timezone',
            'sunday_lunch' => 'nullable|string',
            'sunday_isWork' => 'nullable|string',
            'sunday_ot_rate' => 'nullable|string',
            'sunday_minimum' => 'nullable|integer',
            'sunday_allowance' => 'nullable|integer',
            'monday_in' => 'nullable|timezone',
            'monday_out' => 'nullable|timezone',
            'monday_lunch' => 'nullable|string',
            'monday_isWork' => 'nullable|string',
            'monday_ot_rate' => 'nullable|string',
            'monday_minimum' => 'nullable|integer',
            'monday_allowance' => 'nullable|integer',
            'tuesday_in' => 'nullable|timezone',
            'tuesday_out' => 'nullable|timezone',
            'tuesday_lunch' => 'nullable|string',
            'tuesday_isWork' => 'nullable|string',
            'tuesday_ot_rate' => 'nullable|string',
            'tuesday_minimum' => 'nullable|integer',
            'tuesday_allowance' => 'nullable|integer',
            'wedness_in' => 'nullable|timezone',
            'wedness_out' => 'nullable|timezone',
            'wedness_lunch' => 'nullable|string',
            'wedness_isWork' => 'nullable|string',
            'wedness_ot_rate' => 'nullable|string',
            'wedness_minimum' => 'nullable|integer',
            'wedness_allowance' => 'nullable|integer',
            'thusday_in' => 'nullable|timezone',
            'thusday_out' => 'nullable|timezone',
            'thusday_lunch' => 'nullable|string',
            'thusday_isWork' => 'nullable|string',
            'thusday_ot_rate' => 'nullable|string',
            'thusday_minimum' => 'nullable|integer',
            'thusday_allowance' => 'nullable|integer',
            'friday_in' => 'nullable|timezone',
            'friday_out' => 'nullable|timezone',
            'friday_lunch' => 'nullable|string',
            'friday_isWork' => 'nullable|string',
            'friday_ot_rate' => 'nullable|string',
            'friday_minimum' => 'nullable|integer',
            'friday_allowance' => 'nullable|integer',
            'saturday_in' => 'nullable|timezone',
            'saturday_out' => 'nullable|timezone',
            'saturday_lunch' => 'nullable|string',
            'saturday_isWork' => 'nullable|string',
            'saturday_ot_rate' => 'nullable|string',
            'saturday_minimum' => 'nullable|integer',
            'saturday_allowance' => 'nullable|integer',
        ];
    }
}
