<?php

namespace App\Http\Controllers;

use App\Models\remarkstype;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RemarksTypesController extends Controller
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
        if (is_null($this->user) || !$this->user->can('remarks-type.index')) {
            abort(403, 'Unauthorized');
        }
        $datas = remarkstype::latest()->get();
        return view('admin.remarkType.index', compact('datas'));
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
        if (is_null($this->user) || !$this->user->can('remarks-type.store')) {
            abort(403, 'Unauthorized');
        }
        $request->validate([
            'remarkstype_code' => 'required|unique:remarkstypes',
            'remarkstype_desc' => 'required',
            'remarkstype_seqno' => 'nullable|integer',
        ]);

        remarkstype::create($request->except('_token'));
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
        $data = remarkstype::find($id);
        return view('admin.remarkType.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, remarkstype $remarks_type)
    {
        if (is_null($this->user) || !$this->user->can('remarks-type.update')) {
            abort(403, 'Unauthorized');
        }
        $request->validate([
            'remarkstype_code' => "required|unique:remarkstypes,remarkstype_code,{$remarks_type->id}",
            'remarkstype_desc' => 'required',
            'remarkstype_seqno' => 'nullable|integer',
        ]);

        $remarks_type->update($request->except('_token'));
        return back()->with('success', 'Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(remarkstype $remarks_type)
    {
        if (is_null($this->user) || !$this->user->can('remarks-type.destroy')) {
            abort(403, 'Unauthorized');
        }
        $remarks_type->delete();
        return back()->with('success', 'Deleted Successfully.');
    }
}
