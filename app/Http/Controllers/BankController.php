<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BankController extends Controller
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
        if (is_null($this->user) || !$this->user->can('bank.index')) {
            abort(403, 'Unauthorized');
        }
        $datas = Bank::latest()->get();
        return view('admin.bank.index', compact('datas'));
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
        if (is_null($this->user) || !$this->user->can('bank.store')) {
            abort(403, 'Unauthorized');
        }
        $request->validate([
            'bank_no' => 'required|integer',
            'bank_code' => 'required|string',
            'seq_no' => 'required|integer',
            'description' => 'string|nullable',
        ]);
        Bank::create($request->except('_token'));
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
    public function edit(Bank $bank)
    {
        return view('admin.bank.edit', compact('bank'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bank $bank)
    {
        if (is_null($this->user) || !$this->user->can('bank.update')) {
            abort(403, 'Unauthorized');
        }
        $request->validate([
            'bank_no' => 'required|integer',
            'bank_code' => 'required|string',
            'seq_no' => 'required|integer',
            'description' => 'string|nullable',
        ]);
        $bank->update($request->except('_token'));
        return back()->with('success', 'Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bank $bank)
    {
        if (is_null($this->user) || !$this->user->can('bank.destroy')) {
            abort(403, 'Unauthorized');
        }
        $bank->delete();
        return back()->with('success', 'Deleted successfully.');
    }
}
