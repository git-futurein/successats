<?php

namespace App\Http\Controllers;

use App\Models\Religion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReligionController extends Controller
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
        if (is_null($this->user) || !$this->user->can('religion.index')) {
            abort(403, 'Unauthorized');
        }
        $datas = Religion::orderBy('religion_seqno')->get();
        return view('admin.religion.index', compact('datas'));
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
        if (is_null($this->user) || !$this->user->can('religion.store')) {
            abort(403, 'Unauthorized');
        }
        $request->validate([
            'religion_code' => 'required|unique:religions',
            'religion_desc' => 'required',
            'religion_seqno' =>  'nullable|integer'
        ]);

        Religion::create($request->except('_token'));
        return back()->with('success', 'Added Successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Religion $religion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Religion $religion)
    {
        return view('admin.religion.edit', compact('religion'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Religion $religion)
    {
        if (is_null($this->user) || !$this->user->can('religion.update')) {
            abort(403, 'Unauthorized');
        }
        $request->validate([
            'religion_code' => "required|unique:religions,religion_code,{$religion->id}",
            'religion_desc' => 'required',
            'religion_seqno' =>  'nullable|integer'
        ]);

        $religion->update($request->except('_token'));
        return back()->with('success', 'Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Religion $religion)
    {
        if (is_null($this->user) || !$this->user->can('religion.destroy')) {
            abort(403, 'Unauthorized');
        }
        $religion->delete();

        return back()->with('success', 'Deleted Successfully.');

    }
}
