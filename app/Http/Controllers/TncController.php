<?php

namespace App\Http\Controllers;

use App\Helpers\FileHelper;
use App\Models\TncTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TncController extends Controller
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
        if (is_null($this->user) || !$this->user->can('tnc.index')) {
            abort(403, 'Unauthorized');
        }
        $datas = TncTemplate::orderBy('tnc_template_seqno')->get();
        return view('admin.tnc.index', compact('datas'));
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
        if (is_null($this->user) || !$this->user->can('tnc.store')) {
            abort(403, 'Unauthorized');
        }
        $request->validate([
            'tnc_template_code' => 'required|unique:tnc_templates',
            'tnc_template_desc' => 'required',
            'tnc_template_file_path' => 'nullable|mimes:pdf|max:2048',
            'tnc_template_seqno' => 'nullable|integer',
        ]);

        // $file_path = $request->file('tnc_template_file_path');

        // Check if $file_path is not empty before proceeding
        if ($request->hasFile('tnc_template_file_path')) {
            // if ($file_path) {
            $uploadedFilePath = FileHelper::uploadFile($request->file('tnc_template_file_path'), 'tnc');

            TncTemplate::create($request->except('_token', 'tnc_template_file_path') + [
                'tnc_template_file_path' => $uploadedFilePath,
            ]);

            return back()->with('success', 'Created successfully.');
        } else {

            TncTemplate::create($request->except('_token', 'tnc_template_file_path'));
            return back()->with('success', 'Created successfully.');
        }
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
    public function edit(TncTemplate $tnc)
    {
        return view('admin.tnc.edit', compact('tnc'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TncTemplate $tnc)
    {
        if (is_null($this->user) || !$this->user->can('tnc.update')) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'tnc_template_code' => "required|unique:tnc_templates,tnc_template_code,{$tnc->id}",
            'tnc_template_desc' => 'required',
            'tnc_template_file_path' => 'nullable|mimes:pdf|max:2048',
            'tnc_template_seqno' => 'nullable|integer',
        ]);

        if ($request->hasFile('tnc_template_file_path')) {
            Storage::delete("public/{$tnc->tnc_template_file_path}");

            $uploadedFilePath = FileHelper::uploadFile($request->file('tnc_template_file_path'), 'tnc');

            if ($request->tnc_template_isDefault == 1) {
                TncTemplate::where('tnc_template_isDefault', 1)->update(['tnc_template_isDefault' => 0]);
            }

            $tnc->update([
                'tnc_template_file_path' => $uploadedFilePath,
                'tnc_template_code' => $request->input('tnc_template_code'),
                'tnc_template_desc' => $request->input('tnc_template_desc'),
                'tnc_template_seqno' => $request->input('tnc_template_seqno'),
                'tnc_template_isDefault' => $request->input('tnc_template_isDefault')
            ]);
        } else {

            if ($request->tnc_template_isDefault == 1) {
                TncTemplate::where('tnc_template_isDefault', 1)->update(['tnc_template_isDefault' => 0]);
            }
            $tnc->update($request->except('_token', 'tnc_template_file_path'));
        }
        return back()->with('success', 'Successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TncTemplate $tnc)
    {
        if (is_null($this->user) || !$this->user->can('tnc.destroy')) {
            abort(403, 'Unauthorized');
        }
        if ($tnc->tnc_template_isDefault == 1) {
            return back()->with('error', "You can't delete default template");
        }
        $filePath = storage_path("app/public/{$tnc->tnc_template_file_path}");

        if (file_exists($filePath)) {
            Storage::delete("public/{$tnc->tnc_template_file_path}");
        }
        $tnc->delete();
        return back()->with('success', 'Successfully Deleted.');
    }
}
