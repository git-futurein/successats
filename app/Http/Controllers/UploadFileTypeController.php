<?php

namespace App\Http\Controllers;

use App\Models\uploadfiletype;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UploadFileTypeController extends Controller
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
        if (is_null($this->user) || !$this->user->can('file-type.index')) {
            abort(403, 'Unauthorized');
        }
        $datas = uploadfiletype::latest()->get();
        return view('admin.uploadFileType.index', compact('datas'));
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
        if (is_null($this->user) || !$this->user->can('file-type.store')) {
            abort(403, 'Unauthorized');
        }
        $request->validate([
            'uploadfiletype_code' => 'required|unique:uploadfiletypes',
        ]);
        uploadfiletype::create($request->except('_token'));
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
    public function edit(uploadfiletype $file_type)
    {
        return view('admin.uploadFileType.edit', compact('file_type'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, uploadfiletype $file_type)
    {
        if (is_null($this->user) || !$this->user->can('file-type.update')) {
            abort(403, 'Unauthorized');
        }
        $request->validate([
            'uploadfiletype_code' => "required|unique:uploadfiletypes,uploadfiletype_code,{$file_type->id}",
        ]);
        $file_type->update($request->except('_token'));
        return back()->with('success', 'Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(uploadfiletype $file_type)
    {
        if (is_null($this->user) || !$this->user->can('file-type.destroy')) {
            abort(403, 'Unauthorized');
        }
        $file_type->delete();
        return back()->with('success', 'Deleted successfully.');
    }
}
