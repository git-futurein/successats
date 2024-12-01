<?php

namespace App\Http\Controllers\Api;

use App\Helpers\FileHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    public function jobStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'email' => 'required|email',
            'phone_no' => 'required',
            'resume' => 'required|mimes:pdf,xls,xlsx,doc,docs|max:2048',
            'remark' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        $uploadedFilePath = FileHelper::uploadFile($request->file('resume'));

        $jobApplication = JobApplication::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone_no' => $request->input('phone_no'),
            'resume' => $uploadedFilePath,
            'remark' => $request->input('remark'),
        ]);

        return response()->json(['message' => 'Job application created successfully'], 201);
    }
}
