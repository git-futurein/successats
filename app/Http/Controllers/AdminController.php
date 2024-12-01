<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\Admin;

use Illuminate\Support\Facades\Hash;

use Carbon\Carbon;

use Illuminate\Support\Facades\App;

use Illuminate\Support\Facades\Session;

use Illuminate\Foundation\Validation\ValidatesRequests;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Foundation\Auth\RegistersUsers;

use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Validator;

use Google2FA;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller

{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function root()
    {
        return view('index');
    }

    protected function validator(array $data)

    {

        return Validator::make($data, [

            'name' => ['required', 'string', 'max:255'],

            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins'],

            'password' => ['required', 'string', 'min:6', 'confirmed'],

            'userrole' => ['required', 'integer'],

        ]);

    }

    public function Index(){

        return view('admin.employee.index');

    }



    public function Login(Request $request){

        //dd($request);   //<-----TO CHECK

        $check = $request->all();

        if(Auth::guard('admin')->attempt(['email' => $check['email'], 'password' => $check['password'] ]))

        {
            //$request->session()->flash('login_data', $registration_data);

                $user = Admin::where('email','=',$check['email'])->first();

                $token = $request->get('google2fa');

                        if (Google2FA::verifyKey($user->google2fa_secret, $token)) {

                            $request->session()->remove('email');

                            auth()->loginUsingId($user->id);

                            return redirect()->route('2fa')->with('success', 'Admin Login Successfully!');
                        }

                        return back()->with('error', 'Invalid OTP');
        }
        else{

            return back()->with('error', 'Invalid Email or Password.');

        }

    } //End Method


    public function AdminLogout(){

        Auth::guard('admin')->logout();

        return redirect()->route('login')->with('success', 'Admin Logout Successfully!');

    } //End Method



    public function AdminRegister(){
        return view('admin.admin_register');

    } //End Method



    public function AdminRegisterCreate(Request $request){

       // dd($request);

        $Validator = $request->validate([

           'email' => 'required|string|email|unique:admins',

           'name' => 'required',

           'password' => 'required',

           'userrole' => 'required',

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

    public function completeRegistration(Request $request){

        $data=$request->merge(session('registration_data'));

        return $this->registration($request);

        //dd($data);   //<-----TO CHECK

    }

    public function registration(Request $request){

        Admin::insert([

            'name'       => $request->name,

            'email'      => $request->email,

            'password'   => Hash::make($request->password),

            'created_at' => Carbon::now(),

            'google2fa_secret' => $request->google2fa_secret,

            'userrole' => $request->userrole,

        ]);

        return redirect()->route('admin.contactlist')->with('success', 'Admin Created Successfully!');

    } //End Method


   //User list on admin

   public function contactList(){

        $sellers = Admin::all();

        return view('admin.contact.contacts-list', compact('sellers'));

    } // End Method



    public function deleteClient($id){

        $sellers = Admin::find($id)->delete();

        return redirect()->route('admin.contactlist')->with('success', 'Admin Contact Deleted Successfully!');

        //return view('admin.clientList')->with('success', 'User Deleted Successfully!');

    } // End Method

}

