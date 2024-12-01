<?php

namespace App\Http\Controllers;

use App\Models\passtype;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PassTypeController extends Controller
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
        if (is_null($this->user) || !$this->user->can('pass-type.index')) {
            abort(403, 'Unauthorized');
        }
        $datas =  passtype::orderBy('passtype_seqno')->get();
        return view('admin.passType.index', compact('datas'));
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
        if (is_null($this->user) || !$this->user->can('pass-type.store')) {
            abort(403, 'Unauthorized');
        }
        $request->validate([
            'passtype_code' => 'required|unique:passtypes',
            'passtype_desc' => 'required',
            'passtype_seqno' => 'nullable|integer',
        ]);

        passtype::create($request->except('_token'));
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
    public function edit(string $id)
    {
        $data = passtype::find($id);
        return view('admin.passType.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, passtype $pass_type)
    {
        if (is_null($this->user) || !$this->user->can('pass-type.update')) {
            abort(403, 'Unauthorized');
        }
        $request->validate([
            'passtype_code' => "required|unique:passtypes,passtype_code,{$pass_type->id}",
            'passtype_desc' => 'required',
            'passtype_seqno' => 'nullable|integer',
        ]);

        $pass_type->update($request->except('_token'));
        return back()->with('success', 'Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(passtype $pass_type)
    {
        if (is_null($this->user) || !$this->user->can('pass-type.destroy')) {
            abort(403, 'Unauthorized');
        }
        $pass_type->delete();
        return back()->with('success', 'Deleted Successfully.');
    }
}
