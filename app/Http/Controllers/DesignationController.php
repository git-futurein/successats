<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DesignationController extends Controller
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
        if (is_null($this->user) || !$this->user->can('designation.index')) {
            abort(403, 'Unauthorized');
        }
        $datas = Designation::orderBy('designation_seqno')->get();
        return view('admin.designation.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (is_null($this->user) || !$this->user->can('designation.create')) {
            abort(403, 'Unauthorized');
        }
        return view('admin.designation.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('designation.store')) {
            abort(403, 'Unauthorized');
        }
        $request->validate([
            'designation_code' => 'required|string|unique:designations',
            'designation_desc' => 'required|string',
            'designation_seqno' => 'nullable|numeric',
        ]);

        designation::create($request->except('_token'));

        return redirect()->route('designation.index')->with('success', 'Added Successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function show(Designation $designation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Designation $designation)
    {
        return view('admin.designation.edit', compact('designation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Designation $designation)
    {
        if (is_null($this->user) || !$this->user->can('designation.update')) {
            abort(403, 'Unauthorized');
        }
        $request->validate([
            'designation_code' => "required|string|unique:designations,designation_code,". "$designation->id'",
            'designation_desc' => 'required|string',
            'designation_seqno' => 'nullable|numeric',
            'designation_status' => 'required',
        ]);

        $designation->update($request->except('_token'));
        return redirect()->route('designation.index')->with('success', 'Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Designation $designation)
    {
        if (is_null($this->user) || !$this->user->can('designation.destroy')) {
            abort(403, 'Unauthorized');
        }
        $designation->delete();
        return back()->with('success', 'Delete successfully.');
    }
}
