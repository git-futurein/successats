<?php

namespace App\Http\Controllers;

use App\Helpers\FileHelper;
use App\Models\job;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class FrontendJobController extends Controller
{
    public function index()
    {
        $jobs = job::latest()->get();
        return view('job.index', compact('jobs'));
    }

    public function job_details(job $job)
    {
        return view('job.form', compact('job'));
    }

    public function apply(Request $request)
    {
        $file_path = $request->file('cv');
        $cv = $file_path ? FileHelper::uploadFile($file_path, 'application') : null;
        JobApplication::create([
            'job_ids' => $request->job_id,
            'name' => $request->name,
            'phone_no' => $request->mobile,
            'email' => $request->email,
            'remark' => $request->remark,
            'resume' => $cv
        ]);

        return back();
    }
}
