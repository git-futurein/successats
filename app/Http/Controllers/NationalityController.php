<?php

namespace App\Http\Controllers;

use App\Models\Nationality;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NationalityController extends Controller
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
        if (is_null($this->user) || !$this->user->can('nationality.index')) {
            abort(403, 'Unauthorized');
        }
        $datas = Nationality::latest()->get();
        return view('admin.nationality.index', compact('datas'));
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
        if (is_null($this->user) || !$this->user->can('nationality.store')) {
            abort(403, 'Unauthorized');
        }
        $request->validate([
            'nationality_code' => 'required|string',
            'seq_no' => 'nullable',
            'description' => 'string|nullable',
        ]);

        Nationality::create($request->except('_token'));

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
    public function edit(Nationality $nationality)
    {
        return view('admin.nationality.edit', compact('nationality'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Nationality $nationality)
    {
        if (is_null($this->user) || !$this->user->can('nationality.update')) {
            abort(403, 'Unauthorized');
        }
        $request->validate([
            'nationality_code' => 'required|string',
            'seq_no' => 'nullable',
            'description' => 'string|nullable',
        ]);
        $nationality->update($request->except('_token'));
        return back()->with('success', 'Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Nationality $nationality)
    {
        if (is_null($this->user) || !$this->user->can('nationality.destroy')) {
            abort(403, 'Unauthorized');
        }
        $nationality->delete();
        return back()->with('success', 'Deleted successfully.');
    }
}
