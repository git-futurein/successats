<?php

namespace App\Http\Controllers;

use App\Models\IndustryType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
class IndustryTypeController extends Controller
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
        if (is_null($this->user) || !$this->user->can('industry-type.index')) {
            abort(403, 'Unauthorized');
        }
        $datas = IndustryType::orderBy('industry_seqno')->get();
        return view('admin.industryType.index', compact('datas'));
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
        if (is_null($this->user) || !$this->user->can('industry-type.store')) {
            abort(403, 'Unauthorized');
        }
        $request->validate([
            'industry_code' => "required|unique:industry_types",
            'industry_desc' => 'required',
            'industry_seqno' =>  'nullable|integer'
        ]);

        IndustryType::create($request->except('_token'));
        return back()->with('success', 'Successfully added.');
    }

    /**
     * Display the specified resource.
     */
    public function show(IndustryType $industryType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(IndustryType $industry_type)
    {
        return view('admin.industryType.edit', compact('industry_type'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, IndustryType $industry_type)
    {
        if (is_null($this->user) || !$this->user->can('industry-type.update')) {
            abort(403, 'Unauthorized');
        }
        $request->validate([
            'industry_code' => "required|unique:industry_types,industry_code,{$industry_type->id}",
            'industry_desc' => 'required',
            'industry_seqno' =>  'nullable|integer'
        ]);

        $industry_type->update($request->except('_token'));
        return back()->with('success', 'Successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IndustryType $industry_type)
    {
        if (is_null($this->user) || !$this->user->can('industry-type.destroy')) {
            abort(403, 'Unauthorized');
        }
        $industry_type->delete();
        return back()->with('success', 'Successfully deleted.');
    }
}
