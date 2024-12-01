<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Giro;
use App\Models\Paybank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GiroController extends Controller
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
        if (is_null($this->user) || !$this->user->can('giro.index')) {
            abort(403, 'Unauthorized');
        }
        $datas = Giro::latest()->get();
        // $banks = Bank::latest()->get();
        $banks = Paybank::latest()->get();
        return view('admin.giro.index', compact('datas', 'banks'));
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
        if (is_null($this->user) || !$this->user->can('giro.store')) {
            abort(403, 'Unauthorized');
        }
        $request->validate([
            'giro_no' => 'required|integer',
            'bank_id' => 'required|integer',
            'description' => 'string|nullable',
        ]);
        Giro::create($request->except('_token'));
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
    public function edit(Giro $giro)
    {
        $banks = Bank::latest()->get();
        return view('admin.giro.edit', compact('giro', 'banks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Giro $giro)
    {
        if (is_null($this->user) || !$this->user->can('giro.update')) {
            abort(403, 'Unauthorized');
        }
        $request->validate([
            'giro_no' => 'required|integer',
            'bank_id' => 'required|integer',
            'description' => 'string|nullable',
        ]);
        $giro->update($request->except('_token'));
        return back()->with('success', 'Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Giro $giro)
    {
        if (is_null($this->user) || !$this->user->can('giro.destroy')) {
            abort(403, 'Unauthorized');
        }
        $giro->delete();
        return back()->with('success', 'Deleted successfully.');
    }
}
