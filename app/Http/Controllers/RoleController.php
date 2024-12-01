<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use DB;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public $user;


    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('web')->user();
            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        if (is_null($this->user) || !$this->user->can('roles.index')) {
            abort(403, 'Unauthorized');
        }
        return view('admin.roles.index', [
            'roles' => Role::orderBy('id','DESC')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        if (is_null($this->user) || !$this->user->can('roles.create')) {
            abort(403, 'Unauthorized');
        }
        $all_permissions  = Permission::all();
        $permission_groups = User::getpermissionGroups();
        return view('admin.roles.create', compact('all_permissions', 'permission_groups'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request): RedirectResponse
    {

        if (is_null($this->user) || !$this->user->can('roles.store')) {
            abort(403, 'Unauthorized');
        }
        // Validation Data
        $request->validate([
            'name' => 'required|max:100|unique:roles'
        ], [
            'name.requried' => 'Please give a role name'
        ]);

        // Process Data
        $role = Role::create(['name' => $request->name]);

        // $role = DB::table('roles')->where('name', $request->name)->first();
        $permissions = $request->input('permissions');

        if (!empty($permissions)) {
            $role->syncPermissions($permissions);
        }
        return redirect()->route('roles.index')->with('success', 'Role Created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role): View
    {
        if (is_null($this->user) || !$this->user->can('roles.edit')) {
            abort(403, 'Unauthorized');
        }

        $role = Role::findById($role->id);
        $all_permissions = Permission::all();
        $permission_groups = User::getpermissionGroups();
        return view('admin.roles.edit', compact('role', 'all_permissions', 'permission_groups'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role): RedirectResponse
    {
        if (is_null($this->user) || !$this->user->can('roles.update')) {
            abort(403, 'Unauthorized');
        }
        $request->validate([
            'name' => 'required|max:100|unique:roles,name,' . $role->id
        ], [
            'name.requried' => 'Please give a role name'
        ]);

        $role = Role::findById($role->id);
        $permissions = $request->input('permissions');

        if (!empty($permissions)) {
            $role->syncPermissions($permissions);
        }

        return redirect()->route('roles.index')->with('success', 'Role has been updated !!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        if (is_null($this->user) || !$this->user->can('roles.destroy')) {
            abort(403, 'Unauthorized');
        }
        $role->delete();
        return redirect()->route('roles.index')->with('Role is deleted successfully.');
    }
}
