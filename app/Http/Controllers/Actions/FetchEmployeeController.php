<?php

namespace App\Http\Controllers\Actions;

use App\Http\Controllers\Controller;
use \Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Employee;
class FetchEmployeeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(): JsonResponse
    {
        $Employees = Employee::with('User')->get()
            ->transform(function($Employee){
                return [
                    'id' => $Employee->id,
                    'full_name' => $Employee->employee_name,
                    'email' => $Employee->employee_email,
                    'phone' => $Employee->employee_phone,
                    'mobile' => $Employee->employee_mobile,
                    'userid' => $Employee->employee_name,
                    'joindate' => $Employee->employee_joindate,
                   //'status' => $this->getStatus($Employee->employee_status),
                   'status' => $Employee->employee_status,
                    'edit_url' => route('employee.edit', $Employee->id),
                    'delete_url' => route('employee.destroy', $Employee->id)
                ];
            });
      // dd($Employees);
        return response()->json($Employees);
    }

}
