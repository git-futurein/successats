<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Designation;
use App\Models\Department;
use App\Models\paymode;
use App\Helpers\FileHelper;
use App\Http\Requests\StoreEmployeeRequest;
use App\Models\client;
use App\Models\dbsex;
use App\Models\EmployeeSalaryInfo;
use App\Models\LeaveType;
use App\Models\maritalStatus;
use App\Models\passtype;
use App\Models\Race;
use App\Models\Religion;
use App\Models\User;
use App\Models\Paybank;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use \Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

use Google2FA;

class EmployeeController extends Controller
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
        if (is_null($this->user) || !$this->user->can('employee.index')) {
            abort(403, 'Unauthorized');
        }

        $auth = Auth::user()->employe;
        $datas = Employee::with('role_data', 'Designation')->where('active_status', 1)->latest();
        if ($auth->roles_id == 4) {
            $datas->where('manager_users_id', $auth->id);
        } elseif ($auth->roles_id == 11) {
            $datas->where('team_leader_users_id', $auth->id);
        }

        $datas = $datas->get();

        return view('admin.employee.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (is_null($this->user) || !$this->user->can('employee.create')) {
            abort(403, 'Unauthorized');
        }
        $rols = Role::latest()->where('guard_name', 'web')->get();
        $departments = Department::orderBy('department_seqno')->where('department_status', '1')->select('id', 'department_code')->get();
        $designations = Designation::orderBy('designation_seqno')->where('designation_status', '1')->select('id', 'designation_code')->get();
        $paymode = paymode::orderBy('paymode_seqno')->where('paymode_status', '1')->get();

        $passes = passtype::latest()->where('passtype_status', 1)->select('id', 'passtype_code')->get();
        $users = User::latest()->select('id', 'name')->get();
        $roles = Role::latest()->select('id', 'name')->where('active_status', 0)->get();
        $races = Race::latest()->select('id', 'race_code')->where('race_status', 1)->get();
        $religions = Religion::latest()->select('id', 'religion_code')->where('religion_status', 1)->get();
        $sexs = dbsex::latest()->select('id', 'dbsexes_code')->where('dbsexes_status', 1)->get();
        $marital_status = maritalStatus::latest()->select('id', 'marital_statuses_code')->where('marital_statuses_status', 1)->get();
        $clients = client::latest()->select('id', 'client_code')->where('clients_status', 1)->get();
        $Paybanks = Paybank::orderBy('Paybank_seqno')->select('id', 'Paybank_code')->where('Paybank_status', 1)->get();
        $emp_admin = Employee::select('id', 'employee_name')->where('roles_id', 1)->get();
        $managers = Employee::select('id', 'employee_name')->where('roles_id', 4)->get();


        $emp_team_leader = Employee::select('id', 'employee_name')->where('roles_id', 11)->get();

        $leave_types = LeaveType::latest()->select('id', 'leavetype_code', 'leavetype_default')->where('leavetype_status', 1)->get();

        return view('admin.employee.create', compact('Paybanks', 'managers', 'emp_admin', 'rols', 'departments', 'designations', 'paymode', 'passes', 'users', 'roles', 'races', 'religions', 'sexs', 'marital_status', 'clients', 'leave_types', 'emp_team_leader'));
    }

    private function sendResetEmail($email)
    {
        //Retrieve the user from the database
        $user = DB::table('users')->where('email', $email)->select('name', 'email', 'google2fa_secret')->first();
        $google2fa_secret = $user->google2fa_secret;
        //Generate, the password reset link. The token generated is embedded in the link
        $data[] = array('users' =>  $user);
        $data["email"] = $user->email;
        $data["name"] = $user->name;
        $data["google2fa_secret"] = $user->google2fa_secret;
        try {
            Mail::send('google2fa.sendcode', compact('user'), function ($message) use ($data) {
                $message->to($data["email"])
                    ->subject('Set up Google Authenticator for ' . $data["name"]);
            });
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeeRequest $request)
    {

        if (is_null($this->user) || !$this->user->can('employee.store')) {
            abort(403, 'Unauthorized');
        }

        // if($this->user->employe->roles_id == 4)
        // {
        //     $request['manager_users_id'] = $this->user->employe->id;
        // } elseif ($this->user->employe->roles_id == 11) {
        //     $request['team_leader_users_id'] = $this->user->employe->id;
        //     $request['manager_users_id'] = $this->user->employe->manager_users_id;
        // }

        $file_path = $request->file('employee_avater');

        // Check if $file_path is not empty before proceeding
        if ($file_path) {
            $uploadedFilePath = FileHelper::uploadFile($file_path);

            $employee = Employee::create($request->except('_token', 'employee_avater', 'user_table_id') + [
                'employee_avater' => $uploadedFilePath,
            ]);

            if ($request->email) {
                $request->validate([
                    'email' => 'required',
                    'password' => 'required|min:8',
                    'password_confirmation' => 'required|min:8',
                ]);

                $google2fa = app('pragmarx.google2fa');

                // Create New User
                $user = new User();
                $user->name = $request->employee_name;
                $user->email = $request->email;
                $user->role = $request->passtypes_id;
                $user->password = Hash::make($request->password);
                $user->google2fa_secret = $google2fa->generateSecretKey();
                $user->save();
                $this->sendResetEmail($user->email);

                $role = Role::where('id', $request->roles_id)->first()->name;
                if ($request->roles_id) {
                    $user->assignRole($role);
                    $employee->update([
                        'user_table_id' => $user->id,
                    ]);
                }
            }

            return redirect()->route('employee.index')->with('success', 'Created successfully.');
        } else {

            $employee = Employee::create($request->except('_token', 'employee_avater', 'user_table_id'));

            if ($request->email) {
                $request->validate([
                    'email' => 'required',
                    'password' => 'required|min:8',
                    'password_confirmation' => 'required|min:8',
                ]);

                $google2fa = app('pragmarx.google2fa');

                // Create New User
                $user = new User();
                $user->name = $request->employee_name;
                $user->email = $request->email;
                $user->password = Hash::make($request->password);
                $user->google2fa_secret = $google2fa->generateSecretKey();
                $user->save();
                $this->sendResetEmail($user->email);

                $role = Role::where('id', $request->roles_id)->first()->name;
                if ($request->roles_id) {
                    $user->assignRole($role);
                    $employee->update([
                        'user_table_id' => $user->id,
                    ]);
                }
            }
            return redirect()->route('employee.index')->with('success', 'Created successfully.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        if (is_null($this->user) || !$this->user->can('employee.edit')) {
            abort(403, 'Unauthorized');
        }

        $rols = Role::latest()->where('guard_name', 'web')->get();
        $departments = Department::orderBy('department_seqno')->where('department_status', '1')->select('id', 'department_code')->get();
        $designations = Designation::orderBy('designation_seqno')->where('designation_status', '1')->select('id', 'designation_code')->get();
        $paymode = paymode::orderBy('paymode_seqno')->where('paymode_status', '1')->get();
        $passes = passtype::latest()->where('passtype_status', 1)->select('id', 'passtype_code')->get();
        $users = User::latest()->select('id', 'name')->get();
        $roles = Role::latest()->select('id', 'name')->where('active_status', 0)->get();
        $races = Race::latest()->select('id', 'race_code')->where('race_status', 1)->get();
        $religions = Religion::latest()->select('id', 'religion_code')->where('religion_status', 1)->get();
        $sexs = dbsex::latest()->select('id', 'dbsexes_code')->where('dbsexes_status', 1)->get();
        $marital_status = maritalStatus::latest()->select('id', 'marital_statuses_code')->where('marital_statuses_status', 1)->get();
        $clients = client::latest()->select('id', 'client_code')->where('clients_status', 1)->get();
        $Paybanks = Paybank::orderBy('Paybank_seqno')->select('id', 'Paybank_code')->where('Paybank_status', 1)->get();
        $managers = Employee::select('id', 'employee_name')->where('roles_id', 4)->get();

        $emp_manager = Employee::select('id', 'employee_name')->where('roles_id', 4)->get();

        $emp_team_leader = Employee::select('id', 'employee_name')->where('roles_id', 11)->get();

        $emp_admin = Employee::select('id', 'employee_name')->where('roles_id', 1)->get();
        $leave_types = LeaveType::latest()->select('id', 'leavetype_code', 'leavetype_default')->where('leavetype_status', 1)->get();

        return view('admin.employee.edit', compact('Paybanks', 'managers', 'emp_manager', 'emp_admin', 'employee', 'rols', 'departments', 'designations', 'paymode', 'passes', 'users', 'roles', 'races', 'religions', 'sexs', 'marital_status', 'clients', 'emp_team_leader', 'leave_types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreEmployeeRequest $request, Employee $employee)
    {
        return $request;
        if (is_null($this->user) || !$this->user->can('employee.update')) {
            abort(403, 'Unauthorized');
        }

        // if ($this->user->employe->roles_id == 4) {
        //     $request['manager_users_id'] = $this->user->employe->id;
        // } elseif ($this->user->employe->roles_id == 11) {
        //     $request['team_leader_users_id'] = $this->user->employe->id;
        //     $request['manager_users_id'] = $this->user->employe->manager_users_id;
        // }

        if ($request->hasFile('employee_avater')) {
            // Delete the old file
            Storage::delete("public/{$employee->employee_avater}");

            // Upload the new file
            $uploadedFilePath = FileHelper::uploadFile($request->file('employee_avater'), 'employee');

            // Update the database record
            $employee->update($request->except('_token', 'employee_avater') + [
                'employee_avater' => $uploadedFilePath,
            ]);
        } else {
            $employee->update($request->except('_token', 'employee_avater'));
        }
        return redirect()->route('employee.index')->with('success', 'Updated successfully.');
    }

    public function destroy(Employee $employee)
    {

        if (is_null($this->user) || !$this->user->can('employee.destroy')) {
            abort(403, 'Unauthorized');
        }
        // $filePath = storage_path("app/public/{$employee->employee_avater}");

        // if (file_exists($filePath)) {
        //     Storage::delete("public/{$employee->employee_avater}");
        // }

        $employee->update([
            'active_status' => 0
        ]);
        $user = User::where('id', $employee->user_table_id);
        $user->update([
            'active_status' => 0
        ]);
        return back()->with('success', 'Employee disabled.');
    }

    public function salaryInfoPost(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('employee.salary.info.post')) {
            abort(403, 'Unauthorized');
        }
        $request->validate([
            'employee_id' => 'required|integer',
            'date' => 'required|date',
            'salary_amount' => 'required'
        ]);
        EmployeeSalaryInfo::create($request->except('_token'));
        return back()->with('success', 'Salary Info Added Successfully.');
    }

    public function getTeamleader(Employee $employee)
    {
        $team_leaders = Employee::where('manager_users_id', $employee->id)->where('roles_id', 11)->get();
        return $team_leaders;
    }
    public function getConsultant(Employee $employee)
    {
        $consultants = Employee::where('team_leader_users_id', $employee->id)->where('roles_id', 8)->get();
        return $consultants;
    }
}
