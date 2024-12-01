<?php

namespace App\Http\Controllers;

use App\Models\jobtype;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobTypeController extends Controller
{
    public $user;


    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('web')->user();
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (is_null($this->user) || !$this->user->can('job-type.index')) {
        abort(403, 'Unauthorized');
        }
        $datas = jobtype::latest()->get();
        return view('admin.jobType.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('job-type.store')) {
        abort(403, 'Unauthorized');
        }

        $request->validate([
            'jobtype_code' => 'required|unique:jobtypes',
            'jobtype_desc' => 'required|string',
            'jobtype_seqno' => 'nullable|integer',
        ]);
        jobtype::create($request->except('_token'));
        return back()->with('success', 'Created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(jobtype $job_type)
    {
        return view('admin.jobType.edit', compact('job_type'));
    }

    /**
     * Update the specified resource in storage.The jobtype code field is required.
     */
    public function update(Request $request, jobtype $job_type)
    {
        if (is_null($this->user) || !$this->user->can('job-type.update')) {
        abort(403, 'Unauthorized');
        }
        $request->validate([
            'jobtype_code' => "required|unique:jobtypes,jobtype_code,{$job_type->id}",
            'jobtype_desc' => 'required|string',
            'jobtype_seqno' => 'integer|nullable',
        ]);
        $job_type->update($request->except('_token'));
        return back()->with('success', 'Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(jobtype $job_type)
    {
        if (is_null($this->user) || !$this->user->can('job-type.destroy')) {
        abort(403, 'Unauthorized');
        }
        $job_type->delete();
        return back()->with('success', 'Deleted Successfully.');
    }
}
