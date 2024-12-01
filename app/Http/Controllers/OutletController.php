<?php

namespace App\Http\Controllers;

use App\Models\country;
use App\Models\Outlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class OutletController extends Controller
{
    public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('web')->user();
            return $next($request);
        });
    }

    public function index()
    {
        // if (is_null($this->user) || !$this->user->can('outlet.index')) {
        //     abort(403, 'Unauthorized');
        // }

        $datas = Outlet::latest()->get();
        return view('admin.outlet.index', compact('datas'));
    }
    public function create()
    {
        // if (is_null($this->user) || !$this->user->can('company.create')) {
        //     abort(403, 'Unauthorized');
        // }
        $countries = country::latest()->get();

        return view('admin.outlet.create', compact('countries'));
    }

    private function outletValidation($request)
    {
        $validator = Validator::make($request->all(), [
            'outlet_name'        => 'required|string',
            'outlet_tel'         => 'nullable|numeric',
            'outlet_fax'         => 'nullable|string',
            'outlet_email'       => 'required|email',
            'outlet_website'     => 'nullable|url',
            'outlet_gstno'       => 'nullable|string',
            'outlet_gstpercent'  => 'nullable|numeric',
            'outlet_license'     => 'nullable|string',
            'outlet_description' => 'nullable|string',
            'outlet_address'     => 'nullable|string',
            'countries_id'       => 'nullable|exists:countries,id',
            'created_by'         => 'nullable|integer',
            'modify_by'          => 'nullable|integer',
        ]);

        return $validator;
    }

    public function store(Request $request)
    {
        $validator = $this->outletValidation($request);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

        $query = Outlet::create($validated);

        if(!$query) return redirect()->back()->with('error', 'Something Error!!! Try Again.');
        return redirect()->route('outlets.index')->with('success', 'Created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(outlet $outlet)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Outlet $outlet)
    {
        $countries = country::latest()->get();
        return view('admin.outlet.edit', compact('outlet', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Outlet $outlet)
    {
        $validator = $this->outletValidation($request);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();
        $query = $outlet->update($validated);

        if (!$query) return redirect()->back()->with('error', 'Something Error!!! Try Again.');
        return redirect()->route('outlets.index')->with('success', 'Update successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Outlet $outlet)
    {
        $query = $outlet->delete();
        if (!$query) return redirect()->back()->with('error', 'Something Error!!! Try Again.');
        return redirect()->route('outlets.index')->with('success', 'Delete successfully.');
    }
}
