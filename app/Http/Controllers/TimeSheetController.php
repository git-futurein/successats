<?php

namespace App\Http\Controllers;

use App\Http\Requests\TimeSheeRequest;
use App\Http\Requests\TimeSheetRequest;
use App\Models\TimeSheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TimeSheetController extends Controller
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
        if (is_null($this->user) || !$this->user->can('time-sheet.index')) {
            abort(403, 'Unauthorized');
        }
        $datas = TimeSheet::latest()->get();
        return view('admin.timesheet.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (is_null($this->user) || !$this->user->can('time-sheet.create')) {
            abort(403, 'Unauthorized');
        }
        return view('admin.timesheet.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('time-sheet.store')) {
            abort(403, 'Unauthorized');
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'print' => 'nullable',
            'remark' => 'nullable',
            'entities' => 'required',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();
        $validated['entities'] = json_encode($validated['entities']);

        TimeSheet::create($validated);

        return redirect()->route('time-sheet.index')->with('success', 'Time Sheet created successfully!');
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
    public function edit(TimeSheet $time_sheet)
    {
        if (is_null($this->user) || !$this->user->can('time-sheet.edit')) {
            abort(403, 'Unauthorized');
        }
        return view('admin.timesheet.edit', compact('time_sheet'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TimeSheet $time_sheet)
    {
        if (is_null($this->user) || !$this->user->can('time-sheet.update')) {
            abort(403, 'Unauthorized');
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'print' => 'nullable',
            'remark' => 'nullable',
            'entities' => 'required',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();
        $validated['entities'] = json_encode($validated['entities']);

        // Update the time sheet
        $time_sheet->update($validated);

        // Redirect or return a response
        return redirect()->route('time-sheet.index')->with('success', 'Time Sheet updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TimeSheet $time_sheet)
    {
        if (is_null($this->user) || !$this->user->can('time-sheet.destroy')) {
            abort(403, 'Unauthorized');
        }
        try {
            $time_sheet->entries()->delete();

            $time_sheet->delete();

            return redirect()->route('time-sheet.index')->with('success', 'Timesheet deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('time-sheet.index')->with('error', 'Error deleting timesheet: ' . $e->getMessage());
        }
    }

    public function timeSheetDetails(TimeSheet $timesheet)
    {
        $entries = $timesheet->entities;
        return response()->json(['entries' => $entries]);
    }
}
