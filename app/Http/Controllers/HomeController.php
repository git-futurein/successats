<?php

namespace App\Http\Controllers;

use App\Helpers\FileHelper;
use App\Http\Requests\CandidateRequest;
use App\Http\Requests\PayrollRequest;
use App\Models\candidate;
use App\Models\CandidateFamily;
use App\Models\CandidatePayroll;
use App\Models\CandidateRemark;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Designation;
use App\Models\Department;
use App\Models\paymode;
use App\Models\Race;
use App\Models\maritalStatus;
use App\Models\passtype;
use App\Models\Religion;
use App\Models\uploadfiletype;
use App\Models\ClientUploadFile;
use App\Models\CandidateResume;
use App\Models\CandidateWorkingHour;
use App\Models\client;
use App\Models\jobtype;
use App\Models\country;
use App\Models\Employee;
use App\Models\Outlet;
use App\Models\remarkstype;
use App\Models\User;
use App\Models\Paybank;
use App\Models\TimeSheet;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $auth = Auth::user()->employe;
        $today = Carbon::today();
        // $datas = candidate::latest()->whereDate('created_at',$today)->get();
        $datas = JobApplication::latest()->get();
        //dd($datas);
        return view('index');
    }

}
