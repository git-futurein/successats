<?php

namespace App\Http\Controllers;

use App\Models\LeaveType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveTypeController extends Controller
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
        if (is_null($this->user) || !$this->user->can('leave-type.index')) {
        abort(403, 'Unauthorized');
        }
        $datas = LeaveType::latest()->get();
        return view('admin.leaveType.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (is_null($this->user) || !$this->user->can('leave-type.create')) {
        abort(403, 'Unauthorized');
        }
        return view('admin.leaveType.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('leave-type.store')) {
        abort(403, 'Unauthorized');
        }
        $request->validate([
            'leavetype_code' => 'required|unique:leave_types',
            'leavetype_block' => 'nullable|numeric',
            'leavetype_desc' => 'nullable|string',
            'leavetype_default' => 'nullable|numeric',
            'leavetype_bringover' => 'nullable|numeric',
            'leavetype_custom_field' => 'nullable|numeric',
            'industry_seqno' => 'nullable|numeric',
        ]);

        LeaveType::create($request->except('_token'));
        return redirect()->route('leave-type.index')->with('success', 'Successfully created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(LeaveType $leaveType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LeaveType $leave_type)
    {
        return view('admin.leaveType.edit', compact('leave_type'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LeaveType $leave_type)
    {
        if (is_null($this->user) || !$this->user->can('leave-type.update')) {
        abort(403, 'Unauthorized');
        }
        $request->validate([
            'leavetype_code' => "required|unique:leave_types,leavetype_code,". "$leave_type->id'",
            'leavetype_block' => 'nullable|numeric',
            'leavetype_desc' => 'nullable|string',
            'leavetype_default' => 'nullable|numeric',
            'leavetype_bringover' => 'nullable|numeric',
            'leavetype_custom_field' => 'nullable|numeric',
            'industry_seqno' => 'nullable|numeric',
        ]);

        $leave_type->update($request->except('_token'));
        return redirect()->route('leave-type.index')->with('success', 'Successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LeaveType $leave_type)
    {
        if (is_null($this->user) || !$this->user->can('leave-type.destroy')) {
        abort(403, 'Unauthorized');
        }
        $leave_type->delete();
        return back()->with('success', 'Deleted Successfully.');
    }
}
