<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Mail;
use App\Models\Employee;



use Google2FA;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('admin.users.index', [
            'users' => User::latest('id')->where('active_status', 1)->get()
        ]);
    }


    /**
     * Display a listing of the resource.
     */
    public function dashboard()
    {
        return 'ok';
        // return view('index', [
        //     'users' => User::latest('id')->where('active_status', 1)->get()
        // ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $roles  = Role::all();
        $employees = Employee::where('employee_status', 1)->where('employee_isDeleted', 0)->get();
        return view('admin.users.create', compact('roles', 'employees'));
    }
    /**
     * Getting registration email address.
     */
    public function search(Request $request)
    {


        $data['email'] = Employee::where('employee_name', $request->name)->get("employee_email");
        return response()->json($data);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function storecomplete(Request $request)
    {

        $data = $request->merge(session('registration_data'));

        return $this->registration($request);
    }

    public function registration(Request $request)
    {

        // Create New User
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->google2fa_secret = $request->google2fa_secret;
        $user->save();

        if ($request->roles) {
            $user->assignRole($request->roles);
        }

        if ($this->sendResetEmail($request->email)) {
            return redirect()->back()->with('success', 'A Secrate Code has been sent to registered email address.');
        } else {
            return redirect()->back()->with('error', 'A Network Error occurred. Please try again.');
        }

        return redirect()->route('users.index')->with('success', 'User has been created !!');
    } //End Method

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
    public function store(StoreUserRequest $request)
    {

        // Validation Data
        $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|max:100|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);


        $google2fa = app('pragmarx.google2fa');
        $registration_data = $request->all();
        $registration_data["google2fa_secret"] = $google2fa->generateSecretKey();
        $request->session()->flash('registration_data', $registration_data);
        $QR_Image = $google2fa->getQRCodeInline(
            config('app.name'),
            $registration_data['email'],
            $registration_data['google2fa_secret']
        );
        return view('google2fa.register', ['QR_Image' => $QR_Image, 'secret' => $registration_data['google2fa_secret']]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): View
    {
        return view('users.show', [
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        $user = User::find($user->id);
        $roles  = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // Create New User
        $user = User::find($user->id);

        // Validation Data
        $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|max:100|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
        ]);


        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        $user->roles()->detach();
        if ($request->roles) {
            $user->assignRole($request->roles);
        }

        return redirect()->route('users.index')->with('success', 'User has been created !!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        $user = User::find($user->id);
        if (!is_null($user)) {
            $user->update([
                'active_status' => 0
            ]);
        }

        return back()->with('success', 'User has been disabled !!');
    }

    /**
     * Display the login view.
     */
    public function loginform(): View
    {
        return view('auth.login');
    }

    public function Login(Request $request)
    {

        //dd($request);   //<-----TO CHECK

        $check = $request->all();

        if (Auth::guard('web')->attempt(['email' => $check['email'], 'password' => $check['password']])) {
            if (!Auth::user()->active_status == 1) {
                return back()->with('error', 'Your account is disable please contact with admin.');
            }
            //$request->session()->flash('login_data', $registration_data);

            $user = User::where('email', '=', $check['email'])->first();

            $token = $request->get('google2fa');

            if (Google2FA::verifyKey($user->google2fa_secret, $token)) {

                $request->session()->remove('email');

                auth()->loginUsingId($user->id);

                return redirect()->route('2fa')->with('success', 'Login Successfully!');
            }

            return back()->with('error', 'Invalid OTP');
        } else {

            return back()->with('error', 'Invalid Email or Password.');
        }
    } //End Method

}
