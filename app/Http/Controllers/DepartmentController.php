<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class DepartmentController extends Controller
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
        if (is_null($this->user) || !$this->user->can('department.index')) {
            abort(403, 'Unauthorized');
        }
        $datas = Department::orderBy('department_seqno')->get();
        return view('admin.department.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (is_null($this->user) || !$this->user->can('department.create')) {
            abort(403, 'Unauthorized');
        }
        return view('admin.department.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('department.store')) {
            abort(403, 'Unauthorized');
        }
        $request->validate([
            'department_code' => 'required|string|unique:departments',
            'department_desc' => 'required|string',
            'department_seqno' => 'nullable|numeric',
        ]);

        Department::create($request->except('_token'));

        return redirect()->route('department.index')->with('success', 'Added Successfully.');


    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        return view('admin.department.edit', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department)
    {
        if (is_null($this->user) || !$this->user->can('department.update')) {
            abort(403, 'Unauthorized');
        }
        $request->validate([
            'department_code' => "required|unique:departments,department_code,". "$department->id'",
            'department_desc' => 'required|string',
            'department_seqno' => 'nullable|numeric',
            'department_status' => 'required',
        ]);

        $department->update($request->except('_token'));
        return redirect()->route('department.index')->with('success', 'Updated Successfully.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        if (is_null($this->user) || !$this->user->can('department.destroy')) {
            abort(403, 'Unauthorized');
        }
        $department->delete();
        return back()->with('success', 'Delete successfully.');
    }
}
