<?php

namespace App\Http\Controllers;

use App\Models\clientTerm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientTermController extends Controller
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

        if (is_null($this->user) || !$this->user->can('client-term.index')) {
            abort(403, 'Unauthorized');
        }
        $datas = clientTerm::orderBy('client_term_seqno')->get();

        return view('admin.clientTerm.index', compact('datas'));
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
        if (is_null($this->user) || !$this->user->can('client-term.store')) {
            abort(403, 'Unauthorized');
        }
        $request->validate([
            'client_term_code' => 'required|unique:client_terms',
            'client_term_desc' => 'required',
            'client_term_seqno' => 'nullable|integer',
        ]);

        clientTerm::create($request->except('_token'));
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
    public function edit(clientTerm $client_term)
    {
        return view('admin.clientTerm.edit', compact('client_term'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, clientTerm $client_term)
    {
        if (is_null($this->user) || !$this->user->can('client-term.update')) {
            abort(403, 'Unauthorized');
        }
        $request->validate([
            'client_term_code' => "required|unique:client_terms,client_term_code,{$client_term->id}",
            'client_term_desc' => 'required',
            'client_term_seqno' => 'nullable|integer',
        ]);

        $client_term->update($request->except('_token'));
        return back()->with('success', 'Successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(clientTerm $client_term)
    {
        if (is_null($this->user) || !$this->user->can('client-term.destroy')) {
            abort(403, 'Unauthorized');
        }
        $client_term->delete();

        return back()->with('success', 'Successfully Deleted.');
    }
}
