<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App\Models\DeshboardMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DeshboardMenuController extends Controller
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
        if (is_null($this->user) || !$this->user->can('menu.index')) {
            abort(403, 'Unauthorized');
        }
        $datas = DeshboardMenu::orderBy('menu_short')->get();
        $perents = DeshboardMenu::orderBy('menu_short')->where('menu_perent',0)->select('menu_group', 'id')->get();

        return view('admin.dashboardMenu.index', compact('datas', 'perents'));
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
        if (is_null($this->user) || !$this->user->can('menu.store')) {
            abort(403, 'Unauthorized');
        }

        DeshboardMenu::create($request->except('_token') + [
            'userRole_id' => auth()->id(),
        ]);
        return redirect()->route('menu.index')->with('success', 'Successfully created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(DeshboardMenu $deshboardMenu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DeshboardMenu $menu)
    {

        $perents = DeshboardMenu::where('menu_perent',0)->select('menu_group', 'id')->get();
        return view('admin.dashboardMenu.edit', compact('menu', 'perents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DeshboardMenu $menu)
    {
        if (is_null($this->user) || !$this->user->can('menu.update')) {
            abort(403, 'Unauthorized');
        }
        $menu_perent = DeshboardMenu::where('menu_group', $request->menu_group)->first();
        $menu->update($request->except('_token') + [
            'menu_perent' => $menu_perent->id
        ]);
        return redirect()->route('menu.index')->with('success', 'Successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeshboardMenu $menu)
    {
        if (is_null($this->user) || !$this->user->can('menu.destroy')) {
            abort(403, 'Unauthorized');
        }
        $menu->delete();
        return back()->with('success', 'Successfully deleted.');
    }
}
