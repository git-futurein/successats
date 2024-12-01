<?php

namespace App\Http\Controllers;

use App\Models\maritalStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaritalStatusController extends Controller
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
        if (is_null($this->user) || !$this->user->can('marital-status.index')) {
            abort(403, 'Unauthorized');
        }
        $datas = maritalStatus::orderBy('marital_statuses_seqno')->get();
        return view('admin.maritalStatus.index', compact('datas'));
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
        if (is_null($this->user) || !$this->user->can('marital-status.store')) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'marital_statuses_code' => 'required|unique:marital_statuses',
            'marital_statuses_desc' => 'required',
            'marital_statuses_seqno' => 'nullable|integer',
        ]);

        maritalStatus::create($request->except('_token'));
        return back()->with('success', 'Successfully Added.');
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
    public function edit(maritalStatus $marital_status)
    {
        return view('admin.maritalStatus.edit', compact('marital_status'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, maritalStatus $marital_status)
    {
        if (is_null($this->user) || !$this->user->can('marital-status.update')) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'marital_statuses_code' => "required|unique:marital_statuses,marital_statuses_code,{$marital_status->id}",
            'marital_statuses_desc' => 'required',
            'marital_statuses_seqno' => 'nullable|integer',
        ]);

        $marital_status->update($request->except('_token'));
        return back()->with('success', 'Updated Successfully.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(maritalStatus $marital_status)
    {
        if (is_null($this->user) || !$this->user->can('marital-status.destroy')) {
            abort(403, 'Unauthorized');
        }
        $marital_status->delete();
        return back()->with('success', 'Deleted Successfully.');
    }
}
