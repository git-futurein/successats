<?php

namespace App\Http\Controllers;

use App\Helpers\FileHelper;
use App\Http\Requests\CandidateRequest;
use App\Http\Requests\PayrollRequest;
use App\Models\Assign;
use App\Models\AssignClient;
use App\Models\AssignToRc;
use App\Models\Calander;
use App\Models\Callback;
use App\Models\Candidate;
use App\Models\CandidateFamily;
use App\Models\CandidatePayroll;
use App\Models\CandidateRemark;
use App\Models\CandidateRemarkInterview;
use App\Models\CandidateRemarkShortlist;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Designation;
use App\Models\Department;
use App\Models\Paymode;
use App\Models\Race;
use App\Models\MaritalStatus;
use App\Models\Passtype;
use App\Models\Religion;
use App\Models\Uploadfiletype;
use App\Models\ClientUploadFile;
use App\Models\CandidateResume;
use App\Models\CandidateWorkingHour;
use App\Models\Client;
use App\Models\Jobtype;
use App\Models\Country;
use App\Models\Dashboard;
use App\Models\Employee;
use App\Models\Notification;
use App\Models\Outlet;
use App\Models\Remarkstype;
use App\Models\User;
use App\Models\Paybank;
use App\Models\TimeSheet;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CandidateController extends Controller
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
        if (is_null($this->user) || !$this->user->can('candidate.index')) {
            abort(403, 'Unauthorized');
        }

        $auth = Auth::user()->employe;
        // $datas = Candidate::latest();
        $datas = Candidate::orderBy('id', 'desc');

        if ($auth->roles_id == 4) {
            $datas->where('manager_id', $auth->id);
        } elseif ($auth->roles_id == 11) {
            $datas->where('team_leader_id', $auth->id);
        } elseif ($auth->roles_id == 8) {
            $datas->where('consultant_id', $auth->id);
        }

        $datas = $datas->where('candidate_status', '=', 1)->where('candidate_isDeleted', '=', 0)->get();

        return view('admin.candidate.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (is_null($this->user) || !$this->user->can('candidate.create')) {
            abort(403, 'Unauthorized');
        }


        $department_data = Department::orderBy('department_seqno')->where('department_status', '1')->get();
        $designation_data = Designation::orderBy('designation_seqno')->where('designation_status', '1')->get();
        $paymode_data = Paymode::orderBy('paymode_seqno')->where('paymode_status', '1')->get();
        $race_data = Race::orderBy('race_seqno')->where('race_status', '1')->get();
        $marital_data = MaritalStatus::orderBy('marital_statuses_seqno')->where('marital_statuses_status', '1')->get();
        $passtype_data = Passtype::orderBy('passtype_seqno')->where('passtype_status', '1')->get();
        $religion_data = religion::orderBy('religion_seqno')->where('religion_status', '1')->get();
        $outlet_data = Outlet::latest()->get();
        $clients = Client::latest()->get();
        $nationality = Country::orderBy('en_country_name')->get();
        $Paybanks = Paybank::orderBy('Paybank_seqno')->select('id', 'Paybank_code')->where('Paybank_status', 1)->get();
        return view('admin.candidate.create', compact('Paybanks', 'outlet_data', 'religion_data', 'passtype_data', 'marital_data', 'race_data', 'department_data', 'designation_data', 'paymode_data', 'nationality', 'clients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('candidate.store')) {
            abort(403, 'Unauthorized');
        }

        $validator = Validator::make($request->all(), [
            'consultant_id' => 'nullable|exists:employees,id',
            'candidate_name' => 'required|string|max:255',
            'passtypes_id' => 'nullable|numeric',
            'candidate_nric' => 'nullable|string|max:255',
            'candidate_birthdate' => 'nullable|date',
            'dbsexes_id' => 'nullable|numeric',
            'races_id' => 'nullable|numeric',
            'religions_id' => 'nullable|numeric',
            'nationality_id' => 'nullable|numeric',
            'marital_statuses_id' => 'nullable|numeric',
            'nationality_date_of_issue' => 'nullable|numeric',
            'candidate_mobile' => 'nullable|string|max:10',
            'candidate_home_phone' => 'nullable|string|max:20',
            'candidate_email' => 'required|email|unique:candidates,candidate_email',
            'candidate_address' => 'nullable|string|max:255',
            'candidate_outlet_id' => 'nullable|numeric',
            'candidate_isBlocked' => 'nullable',
            'candidate_postal_code' => 'nullable|string',
            'candidate_unit_number' => 'nullable|string',
            'candidate_street' => 'nullable|string',
            'candidate_postal_code2' => 'nullable|string',
            'candidate_unit_number2' => 'nullable|string',
            'candidate_street2' => 'nullable|string',
            'candidate_emr_contact' => 'nullable|string',
            'candidate_emr_phone1' => 'nullable|string',
            'candidate_emr_address' => 'nullable|string',
            'candidate_emr_relation' => 'nullable|string',
            'candidate_emr_phone2' => 'nullable|string',
            'candidate_emr_remarks' => 'nullable|string',
            'paymodes_id' => 'nullable|string',
            'candidate_bank_acc_title' => 'nullable|string',
            'candidate_bank' => 'nullable|string',
            'candidate_bank_acc_no' => 'nullable|string',
            'candidate_n_level' => 'nullable|string',
            'candidate_o_level' => 'nullable|string',
            'candidate_a_level' => 'nullable|string',
            'candidate_diploma' => 'nullable|string',
            'candidate_degree' => 'nullable|string',
            'candidate_other' => 'nullable|string',
            'candidate_written' => 'nullable|string',
            'candidate_spocken' => 'nullable|string',
            'candidate_referee_name1' => 'nullable|string',
            'candidate_referee_year_know1' => 'nullable|string',
            'candidate_referee_occupation1' => 'nullable|string',
            'candidate_referee_contact1' => 'nullable|string',
            'candidate_referee_name2' => 'nullable|string',
            'candidate_referee_year_know2' => 'nullable|string',
            'candidate_referee_occupation2' => 'nullable|string',
            'candidate_referee_contact2' => 'nullable|string',
            'candidate_dec_bankrupt_details' => 'nullable|string',
            'candidate_dec_physical_details' => 'nullable|string',
            'candidate_dec_lt_medical_details' => 'nullable|string',
            'candidate_dec_law_details' => 'nullable|string',
            'candidate_dec_warning_details' => 'nullable|string',
            'candidate_dec_applied_details' => 'nullable|string',
            'candidate_joindate' => 'nullable|string',
        ]);


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $candidateData = $validator->validate();

        if($request->file('avatar')){
            $request->validate([
                'avatar' => 'mimes:jpg,jpeg,png,webp,gif,bmp,tiff,svg'
            ]);
            try{
                $file_path = $request->file('avatar');
                $candidateData['avatar'] = $file_path ? FileHelper::uploadFile($file_path) : null;
            } catch (\Exception $e) {
                return back()->with('error', $e->getMessage());
            }

        }
        $candidateData['candidate_mobile'] = $request->country_code .' '. $candidateData['candidate_mobile'];

        $auth = Auth::user()->employe;

        if ($auth->roles_id == 4) {
            $candidateData['manager_id'] = $auth->id;
        } elseif ($auth->roles_id == 11) {
            $candidateData['manager_id'] = $auth->manager_users_id;
            $candidateData['team_leader_id'] = $auth->id;
        } elseif($auth->roles_id == 8) {
            $candidateData['manager_id'] = $auth->manager_users_id;
            $candidateData['team_leader_id'] = $auth->team_leader_users_id;
            $candidateData['consultant_id'] = $auth->id;
        }

        try {
            // Begin a transaction
            DB::beginTransaction();
            $candidate = Candidate::create($candidateData);
            $candidate->update(['candidate_code' => 'Cand-' . $candidate->id]);

            $datas = [
                'candidate_id' => $candidate->id,
                'manager_id' => $candidate->manager_id,
                'teamleader_id' => $candidate->team_leader_id,
                'consultent_id' => $candidate->consultant_id,
                'assign_to' => $request->consultant_id ?? Auth::user()->id,
                'insert_by' => Auth::user()->id,
            ];

            CandidateRemark::create([
                'candidate_id' => $candidate->id,
                'remarkstype_id' => 1,
                'isNotice' => 0,
                'assign_to' => $request->consultant_id ?? Auth::user()->id,
                'remarks' => 'Candidate created',
            ]);

            Dashboard::create($datas);
            Assign::create($datas);

            DB::commit();
            // return redirect()->route('candidate.index')->with('success', 'Created successfully.');
            return redirect()->back()->with('success', 'Created successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(candidate $candidate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(candidate $candidate)
    {
        if (is_null($this->user) || !$this->user->can('candidate.edit')) {
            abort(403, 'Unauthorized');
        }
        $auth = Auth::user()->employe;

        if ($auth->roles_id == 11) {
            $team_leader_id = $auth->id;
        } else {
            if (!empty($auth->team_leader_users_id)) {
                $team_leader_id = $auth->team_leader_users_id;
            } else {
                $team_leader_id = null;
            }
        }

        if ($candidate->team_leader_id == $team_leader_id || $auth->roles_id == 1 || $auth->roles_id == 4) {
            $fileTypes = Uploadfiletype::where('uploadfiletype_status', 1)->where('uploadfiletype_for', 1)->latest()->get();
            $department_data = Department::orderBy('department_seqno')->where('department_status', '1')->get();
            $designation_data = Designation::orderBy('designation_seqno')->where('designation_status', '1')->get();
            $paymode_data = Paymode::orderBy('paymode_seqno')->where('paymode_status', '1')->get();
            $race_data = Race::orderBy('race_seqno')->where('race_status', '1')->get();
            $marital_data = MaritalStatus::orderBy('marital_statuses_seqno')->where('marital_statuses_status', '1')->get();
            $passtype_data = Passtype::orderBy('passtype_seqno')->where('passtype_status', '1')->get();
            $religion_data = religion::orderBy('religion_seqno')->where('religion_status', '1')->get();
            $outlet_data = Outlet::orderBy('id')->get();
            $client_files = ClientUploadFile::where('client_id', $candidate->id)->where('file_type_for', 1)->get();
            $remarks_type = Remarkstype::where('remarkstype_status', 1)->select('id', 'remarkstype_code')->latest()->get();
            $client_remarks = CandidateRemark::with('candidate')->where('candidate_id', $candidate->id)->latest()->get();

            $job_types = Jobtype::where('jobtype_status', 1)->select('id', 'jobtype_code')->get();
            $clients = Client::where('clients_status', 1)->latest()->get();
            $payrolls = CandidatePayroll::where('candidate_id', $candidate->id)->latest()->get();
            $families = CandidateFamily::where('candidate_id', $candidate->id)->latest()->get();
            $time = CandidateWorkingHour::where('candidate_id', $candidate->id)->first();
            $candidate_resume = CandidateResume::where('candidate_id', $candidate->id)->latest()->get();
            $nationality = Country::orderBy('en_country_name')->get();
            $users = Employee::where('roles_id', 4)->where('id', '!=', $auth->id)->latest()->get();
            $Paybanks = Paybank::orderBy('Paybank_seqno')->select('id', 'Paybank_code')->where('Paybank_status', 1)->get();
            $time_sheet = TimeSheet::latest()->get();
            $employees = Employee::latest()->get();

            $consultants = User::where('role',8)->get();

            return view('admin.candidate.edit', compact('Paybanks', 'consultants' , 'fileTypes', 'client_files', 'candidate', 'outlet_data', 'religion_data', 'passtype_data', 'marital_data', 'race_data', 'department_data', 'designation_data', 'paymode_data', 'remarks_type', 'client_remarks', 'job_types', 'clients', 'payrolls', 'time', 'families', 'candidate_resume', 'nationality', 'users', 'time_sheet', 'employees'));
        } else {
            return redirect()->back()->with('error', 'Sorry! You enter invalid Candidate id');
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(CandidateRequest $request, candidate $candidate)
    {
        if (is_null($this->user) || !$this->user->can('candidate.update')) {
            abort(403, 'Unauthorized');
        }
        $auth = Auth::user()->employe;

        if ($auth->roles_id == 11) {
            $request['manager_id'] = $auth->manager_users_id;
            $request['team_leader_id'] = $auth->id;
        } elseif ($auth->roles_id == 8) {
            $request['manager_id'] = $auth->manager_users_id;
            $request['team_leader_id'] = $auth->team_leader_users_id;
            $request['consultant_id'] = $auth->id;
        }

        $dashboard = Dashboard::where('candidate_id', $candidate->id)->first();
        $dashboard->update([
            'manager_id' => $request['manager_id'] ?? $dashboard->manager_id,
            'teamleader_id' => $request['team_leader_id'] ?? $dashboard->teamleader_id,
            'consultent_id' => $request['consultant_id'] ?? $dashboard->consultent_id,
        ]);

        if ($request->hasFile('avatar')) {
            // Delete the old file
            Storage::delete("public/{$candidate->avatar}");

            // Upload the new file
            $uploadedFilePath = FileHelper::uploadFile($request->file('avatar'));

            // Update the database record
            $candidate->update($request->except('_token', 'avatar') + [
                'avatar' => $uploadedFilePath,
            ]);
        } else {
            $candidate->update($request->except('_token', 'avatar'));
        }
        return redirect()->back()->with('success', 'Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Candidate $candidate)
    {
        if (is_null($this->user) || !$this->user->can('candidate.destroy')) {
            abort(403, 'Unauthorized');
        }


        $candidate->update([
            'candidate_status' => 3,
            'candidate_isDeleted' => 1
        ]);

        $candidate->user()->update([
            'active_status' => 3
        ]);

        // $filePath = storage_path("app/public/{$candidate->avatar}");

        // if (file_exists($filePath)) {
        //     Storage::delete("public/{$candidate->avatar}");
        // }
        // $candidate->delete();
        return back()->with('success', 'Deleted Successfully.');
    }

    public function fileUpload(Request $request, $id)
    {
        if (is_null($this->user) || !$this->user->can('candidate.file.upload')) {
            abort(403, 'Unauthorized');
        }

        $validator = Validator::make($request->all(), [
            'file_path' => 'required|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
            'file_type_id' => 'required',
        ]);

        $url = '/ATS/candidate/' . $id . '/edit#upload_file';
        if ($validator->fails()) {
            return redirect($url)->withErrors($validator)->withInput();
        }

        $file_path = $request->file('file_path');

        if ($file_path) {
            $uploadedFilePath = FileHelper::uploadFile($file_path);

            ClientUploadFile::create([
                'client_id' => $id,
                'file_path' => $uploadedFilePath,
                'file_type_id' => $request->file_type_id,
                'file_type_for' => $request->file_type_for
            ]);

            return redirect($url)->with('success', 'Created successfully.');
        } else {
            return redirect($url)->with('error', 'Please select a file.');
        }
    }

    public function fileDelete($id, candidate $candidate)
    {
        if (is_null($this->user) || !$this->user->can('candidate.file.delete')) {
            abort(403, 'Unauthorized');
        }
        $file_path_name = ClientUploadFile::where('id', $id)->value('file_path');

        $filePath = storage_path("app/public/{$file_path_name}");

        if (file_exists($filePath)) {
            Storage::delete("public/{$file_path_name}");
        }
        ClientUploadFile::where('id', $id)->delete();

        $url = '/ATS/candidate/' . $candidate->id . '/edit#upload_file';
        return redirect($url)->with('success', 'Successfully Deleted.');
    }

    public function resumeUpload(Request $request, $id)
    {
        if (is_null($this->user) || !$this->user->can('candidate.resume')) {
            abort(403, 'Unauthorized');
        }

        $validator = $request->validate([
            'resume_name' => 'required|string|unique:candidate_resumes,resume_name',
            'resume_file_path' => 'required|mimes:pdf,doc,docx|max:5120',
        ],[
            'resume_file_path.required' => 'Please upload a resume file.',
            'resume_file_path.mimes' => 'The resume file must be a PDF, DOC, or DOCX file.',
            'resume_file_path.max' => 'The resume file size must not exceed 5 MB.',
        ]);
        $url = '/ATS/candidate/' . $id . '/edit#upload_file';

        $file_path = $request->file('resume_file_path');
        $url = '/ATS/candidate/' . $id . '/edit#upload_resume';

        if ($file_path) {
            // $uploadedFilePath = FileHelper::uploadFile($file_path, 'candidate');
            $resumeName = preg_replace('/\s+/', '-', $request->resume_name);
            $filename = $resumeName. '.' .$file_path->getClientOriginalExtension();
            $path = 'uploads/candidate/';
            $file_path->move(public_path('storage/'.$path),$filename);
            $fullPath = $path.$filename;





            // $resume_text = generate_text($uploadedFilePath);
            $hasMain = CandidateResume::where('candidate_id', $id)->where('isMain', 1)->first();
            if($hasMain)
            {
                $hasMain->update(['isMain' => 0]);
            }
            CandidateResume::create([
                'candidate_id' => $id,
                'resume_name' => $request->resume_name,
                'resume_file_path' => $fullPath,
                // 'resume_text' => $resume_text,
                'isMain' => 1
            ]);

            return redirect($url)->with('success', 'Created Successfully.');
        } else {
            return redirect($url)->with('error', 'Please select a file.');
        }
    }

    public function resumeDelete($id, candidate $candidate)
    {
        if (is_null($this->user) || !$this->user->can('candidate.resume.delete')) {
            abort(403, 'Unauthorized');
        }
        $file_path_name = CandidateResume::where('id', $id)->value('resume_file_path');

        $filePath = storage_path("app/public/{$file_path_name}");

        if (file_exists($filePath)) {
            Storage::delete("public/{$file_path_name}");
        }

        CandidateResume::where('id', $id)->where('candidate_id', $candidate->id)->delete();

        return redirect()->route('candidate.edit', [$candidate->id, '#upload_resume'])->with('success', 'successfully Deleted.');
    }

    public function resumeMain(Request $request, Candidate $candidate)
    {
        // return $candidate;
        // if (is_null($this->user) || !$this->user->can('candidate.resume.main')) {
        //     abort(403, 'Unauthorized');
        // }
        $candidate = $candidate->load('resumes');
        foreach ($candidate->resumes as $resume) {
            if ($resume->id == $request->resumeId) {
                $resume->update(['isMain' => 1]);
            } else {
                $resume->update(['isMain' => 0]);
            }
        }
        return response()->json(['message' => 'Resumes updated successfully']);
        // CandidateResume::where('id', '!=', $id)->where('isMain', 1)->update(['isMain' => 0]);
        // $candidate = CandidateResume::findOrFail($id);
        // $candidate->update(['isMain' => $request->input('isMain')]);
    }

    public function remark(Request $request, $id)
    {
        // dd($request->all());
        if (is_null($this->user) || !$this->user->can('candidate.remark')) {
            abort(403, 'Unauthorized');
        }

        $url = '/ATS/candidate/' . $id . '/edit#remark';
        $validator = Validator::make($request->all(), [
            'candidate_id' => 'required|integer',
            'remarkstype_id' => 'required|integer',
            'isNotice' => 'nullable',
            'remarks' => 'required',
            'callbackDate' => 'required_if:remarkstype_id,22',
            'callbackTime' => 'required_if:remarkstype_id,22',
            'shortlistPlacement' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return redirect($url)
                ->withErrors($validator)
                ->withInput();
        }

        $validator->validated();

        $candidate = Candidate::find($id);

        if(!$candidate) return redirect($url)->with('error', 'Candidate Not Found!!');

        $dashboard = Dashboard::where('candidate_id', $request->candidate_id)->first();

        try {
            $assign_to = $request->Assign_to_manager ?? $request->Assign_to_manager_r ?? $request->team_leader ?? $request->rc ?? $request->team_leader ?? 0;
            $client_company = $request->client_company ?? $request->client_company_s ?? $request->interview_company;

            // Begin a transaction
            DB::beginTransaction();
            $auth = Auth::user()->employe;
            $candidate_remark = CandidateRemark::create([
                'candidate_id' => $candidate->id,
                'remarkstype_id' => $request->remarkstype_id,
                'isNotice' => $request->isNotice,
                'remarks' => $request->remarks,
                'ar_no' => $request->client_ar_no,
                'assign_to' => $assign_to,
                'client_company' => $client_company,
                'created_by' => $auth->id
            ]);

            $callback = Callback::where('candidate_id', $candidate->id)->where('status', 5)->first();
            if($callback) {
                $callback->update(['status', 6]);
            }

            $dashboard_data = [];
            $assign_dashboard_remark = assign_dashboard_remark_id($request->remarkstype_id);
            $dashboard_data['candidate_remark_id'] = $candidate_remark->id;
            $dashboard_data['remark_id'] = $assign_dashboard_remark['remark_id'];
            $dashboard_data['follow_day'] = $assign_dashboard_remark['follow_day'];
            $dashboard_data['callback'] = $assign_dashboard_remark['callback'];
            $dashboard_data['client_company'] = $client_company;

            $calander = [
                'manager_id' => $candidate->manager_id,
                'teamleader_id' => $candidate->team_leader_id,
                'consultant_id' => $candidate->consultant_id,
                'candidate_remark_id' => $candidate_remark->id,
            ];

            if ($request->remarkstype_id == 4) {
                $dashboard_data['follow_day'] = ++$dashboard->follow_day;
            }

            if ($request->remarkstype_id == 22) {
                $dashboard_data['callback'] = ++$dashboard->callback;

                $calander['title'] = $candidate->consultant?->employee_code . ' - Call Back -' . $candidate->candidate_name;
                $calander['date'] = $calander['new_date'] = $request->callbackDate;
                $calander['time'] = $request->callbackTime;
                $calander['status'] = 5;
                Calander::create($calander);
                $calander['candidate_id'] = $candidate->id;
                $calander['title'] = 'Callback';
                Callback::create($calander);

                $userIds = array_filter([
                    1,
                    $candidate->manager_id,
                    $candidate->team_leader_id,
                    $candidate->consultant_id
                ]);

                if (!empty($userIds)) {
                    $users = Employee::whereIn('id', $userIds)
                        ->where('active_status', 1)
                        ->get();
                    $record = $calander;
                    foreach ($users as $user) {
                        try {
                            $user->notify(new \App\Notifications\DateUpdatedNotification($record));
                        } catch (\Exception $e) {
                            Log::error('Error sending test notification', [
                                'user_id' => $user->id,
                                'error' => $e->getMessage(),
                            ]);
                        }
                    }
                }
            }

            if ($request->remarkstype_id == 6) {
                $list = AssignClient::create([
                    'client_id' => $request->assign_client_id,
                    'candidate_remark_id' => $candidate_remark->id,
                ]);

                $calander['assign_client_id'] = $list->id;
                $calander['title'] = '09:00 AM -' . $candidate->consultant?->employee_code . ' - 2 Business Days Follow Up with Client -' . $list->client->client_name . ' - ' . $candidate->candidate_name;

                $calander['date'] = twobusinessday($list->created_at);
                $calander['status'] = 1;
                Calander::create($calander);
            }

            if ($request->remarkstype_id == 2) {
                $team = get_team($request->team_leader);
                // $request->Assign_to_manager = $team['manager_id'];
                $candidate->update([
                    'manager_id' => $team['manager_id'],
                    'team_leader_id' => $team['team_leader_id'],
                    'consultant_id' => $team['consultant_id'],
                ]);

                $dashboard_data['manager_id'] = $team['manager_id'];
                $dashboard_data['teamleader_id'] = $team['team_leader_id'];
                $dashboard_data['consultent_id'] = $team['consultant_id'];
            }

            if ($request->remarkstype_id == 1) {
                $team = get_team($request->Assign_to_manager);
                $request->Assign_to_manager = $team['manager_id'];
                $candidate->update([
                    'manager_id' => $team['manager_id'],
                    'team_leader_id' => $team['team_leader_id'],
                    'consultant_id' => $team['consultant_id'],
                ]);

                $dashboard_data['manager_id'] = $team['manager_id'];
                $dashboard_data['teamleader_id'] = $team['team_leader_id'];
                $dashboard_data['consultent_id'] = $team['consultant_id'];
            }

            if ($request->remarkstype_id == 12)
            {
                $team = get_team($request->Assign_to_manager);
                $request->Assign_to_manager = $team['manager_id'];
                $candidate->update([
                    'manager_id' => $team['manager_id'],
                    'team_leader_id' => $team['team_leader_id'],
                    'consultant_id' => $team['consultant_id'],
                ]);

                $dashboard_data['manager_id'] = $team['manager_id'];
                $dashboard_data['teamleader_id'] = $team['team_leader_id'];
                $dashboard_data['consultent_id'] = $team['consultant_id'];
            }

            if ($request->remarkstype_id == 11)
            {
                $team = get_team($auth->id);
                $candidate->update([
                    'manager_id' => $team['manager_id'],
                    'team_leader_id' => $team['team_leader_id'],
                    'consultant_id' => $team['consultant_id'],
                ]);

                $dashboard_data['manager_id'] = $team['manager_id'];
                $dashboard_data['teamleader_id'] = $team['team_leader_id'];
                $dashboard_data['consultent_id'] = $team['consultant_id'];
            }

            if($request->remarkstype_id == 3)
            {
                $team = get_team($request->rc);
                $candidate->update([
                    'manager_id' => $team['manager_id'],
                    'team_leader_id' => $team['team_leader_id'],
                    'consultant_id' => $team['consultant_id'],
                ]);

                $dashboard_data['manager_id'] = $team['manager_id'];
                $dashboard_data['teamleader_id'] = $team['team_leader_id'];
                $dashboard_data['consultent_id'] = $team['consultant_id'];

                AssignToRc::create([
                    'candidate_id' => $request->candidate_id,
                    'rc_id' => $request->rc,
                ]);

                $rework = AssignToRc::where('candidate_id', $request->candidate_id)
                                    ->where('rc_id', $request->rc)
                                    ->count();
                if($rework >= 2)
                {
                    $dashboard_data['remark_id'] = 11;
                }
            }

            if ($request->remarkstype_id == 9) {
                $team = get_team($request->Assign_to_manager_r);
                $request->Assign_to_manager_r = $team['manager_id'];

                $candidate->update([
                    'manager_id' => $team['manager_id'],
                    'team_leader_id' => $team['team_leader_id'],
                    'consultant_id' => $team['consultant_id'],
                ]);

                $dashboard_data['manager_id'] = $team['manager_id'];
                $dashboard_data['teamleader_id'] = $team['team_leader_id'];
                $dashboard_data['consultent_id'] = $team['consultant_id'];
                // $url = '/ATS/candidate';
            }

            if ($request->remarkstype_id == 7) {
                $list = CandidateRemarkShortlist::create([
                    'candidate_remark_id' => $candidate_remark->id,
                    'salary' => $request->shortlistSalary,
                    'depertment' => $request->shortlistDepartment,
                    'hourly_rate' => $request->shortlistHourlyRate,
                    'placement_recruitment_fee' => $request->shortlistPlacement,
                    'admin_fee' => $request->shortlistAdminFee,
                    'start_date' => $request->shortlistStartDate,
                    'end_date' => $request->shortlistContractEndDate,
                    'job_title' => $request->shortlistJobTitle,
                    'reminder_period' => $request->shortlistReminderPeriod,
                    'job_type' => $request->shortlistJobType,
                    'contact_signing_time' => $request->shortlistContractSigningTime,
                    'contact_signing_date' => $request->shortlistContractSigningDate,
                    'probition_period' => $request->shortlistProbationPeriod,
                    'last_day' => $request->shortlistLastDay,
                    'email_notice_time' => $request->shortlistEmailNoticeTime,
                    'email_notice_date' => $request->shortlistEmailNoticeDate,
                ]);

                $calander['candidate_remark_shortlist_id'] = $list->id;
                if ($list->end_date != null) {
                    $week_day = week_calculation($request->shortlistReminderPeriod);
                    $endDate = Carbon::parse($list->end_date);
                    $newEndDate = $endDate->subDays($week_day);

                    $calander['title'] = $candidate->consultant?->employee_code . ' - Contract Ending - '. $candidate_remark->client->client_name . ' - ' . $candidate->candidate_name;
                    $calander['date'] = $newEndDate;
                    $calander['status'] = 4;
                    Calander::create($calander);
                }
                if ($list->start_date != null) {
                    $calander['title'] = $candidate->consultant?->employee_code .' - Shortlisted -' . $candidate_remark->client->client_name . ' - ' . $candidate->candidate_name;
                    $calander['date'] = $list->start_date;
                    $calander['status'] = 2;
                    Calander::create($calander);
                }
                if ($list->contact_signing_date != null) {
                    $calander['title'] =
                    Carbon::parse($list->interview_time)->format('h:i A') . '-' . $candidate->consultant?->employee_code . ' - Contact Signing -' . $candidate_remark->client->client_name . ' - ' . $candidate->candidate_name;
                    $calander['date'] = $list->contact_signing_date;
                    $calander['status'] = 3;
                    Calander::create($calander);
                }
            }

            if ($request->remarkstype_id == 5) {
                $list = CandidateRemarkInterview::create([
                    'candidate_remark_id' => $candidate_remark->id,
                    'interview_date' => $request->interview_date,
                    'interview_time' => $request->interview_time,
                    'interview_by' => $request->interview_by,
                    'interview_position' => $request->interview_position,
                    'interview_company' => $request->interview_company,
                    'expected_salary' => $request->interview_expected_salary,
                    'job_offer_salary' => $request->inteview_job_offer_salary,
                    'available_date' => $request->available_date,
                    'receive_job_offer' => $request->interview_received_job_offer,
                    'email_notice_date' => $request->interviewEmailNoticeDate,
                    'attend_interview' => $request->attendInterview,
                ]);

                $calander['candidate_remark_shortlist_id'] = $list->id;
                $calander['title'] = Carbon::parse($list->interview_time)->format('h:i A') . '-' . $candidate->consultant?->employee_code .' - Interview -'. $list->company->client_name. ' - ' .$candidate->candidate_name;
                $calander['date'] = $calander['new_date'] = $list->interview_date;
                $calander['time'] = $list->interview_time;
                $calander['status'] = 5;
                $calander['candidate_id'] = $candidate->id;
                $calander['title'] = 'Interview';
                Callback::create($calander);

                $userIds = array_filter([
                    1,
                    $candidate->manager_id,
                    $candidate->team_leader_id,
                    $candidate->consultant_id
                ]);

                if (!empty($userIds)) {
                    $users = Employee::whereIn('id', $userIds)
                        ->where('active_status', 1)
                        ->get();
                    $record = $calander;
                    foreach ($users as $user) {
                        try {
                            $user->notify(new \App\Notifications\DateUpdatedNotification($record));
                        } catch (\Exception $e) {
                            Log::error('Error sending test notification', [
                                'user_id' => $user->id,
                                'error' => $e->getMessage(),
                            ]);
                        }
                    }
                }
            }

            $dashboard->update($dashboard_data);
            $candidate = Candidate::find($id);
            Assign::create([
                'candidate_id' => $candidate->id,
                'manager_id' => $request->Assign_to_manager ?? $candidate->manager_id,
                'teamleader_id' => $candidate->team_leader_id ?? null,
                'consultent_id' => $candidate->consultant_id ?? null,
                'insert_by' => Auth::user()->id,
                'remark_id' => $candidate_remark->id,
            ]);

            DB::commit();
            return redirect($url)->with('success', 'Remark added successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect($url)->with('error', $e->getMessage());
        }
    }

    public function remarkDelete($id)
    {
        if (is_null($this->user) || !$this->user->can('candidate.remark.delete')) {
            abort(403, 'Unauthorized');
        }
        $candidate = CandidateRemark::find($id);
        $candidate_id = $candidate->candidate_id;
        $candidate->delete();

        return redirect()->route('candidate.edit', [$candidate_id, '#remark'])->with('success', 'Deleted successfully.');
    }
    public function payroll(PayrollRequest $request, $id)
    {
        if (is_null($this->user) || !$this->user->can('candidate.payroll')) {
            abort(403, 'Unauthorized');
        }

        $request['created_by'] = Auth::user()->employe->id;
        $request['modify_by'] = Auth::user()->employe->id;

        CandidatePayroll::create($request->except('_token'));

        return redirect()->route('candidate.edit', [$request->candidate_id, '#payroll'])->with('success', 'Payroll added successfully.');
    }


    public function payrollDelete($id)
    {
        if (is_null($this->user) || !$this->user->can('candidate.payroll.delete')) {
            abort(403, 'Unauthorized');
        }
        $candidate = CandidatePayroll::find($id);
        $candidate_id = $candidate->candidate_id;
        $candidate->delete();

        return redirect()->route('candidate.edit', [$candidate_id, '#payroll'])->with('success', 'Deleted Successfully.');
    }

    public function workingHour(Request $request, $id)
    {
        if (is_null($this->user) || !$this->user->can('candidate.working.hour')) {
            abort(403, 'Unauthorized');
        }

        // return $request;
        $request->validate([
            'candidate_id' => 'required|integer',
            'timesheet_id' => 'required|integer',
            'schedul_type' => 'required|string',
            'schedul_day' => 'required|integer',
            'remarks' => 'nullable',
        ]);
        $candidate = CandidateWorkingHour::where('candidate_id', $id)->first();
        if (!$candidate) {
            CandidateWorkingHour::create($request->except('_token'));
        } else {
            $candidate->update($request->except('_token'));
        }

        return redirect()->route('candidate.edit', [$id, '#working_hour'])->with('success', 'Working hour successfully updated.');
    }
    public function family(Request $request, $id)
    {
        if (is_null($this->user) || !$this->user->can('candidate.family')) {
            abort(403, 'Unauthorized');
        }
        $request->validate([
            'candidate_id' => 'integer|required',
            'name' => 'string|required',
            'age' => 'integer|required',
            'relationship' => 'string|required',
            'occupation' => 'string|required',
            'contact_no' => 'string|required',
        ]);
        CandidateFamily::create($request->except('_token'));

        return redirect()->route('candidate.edit', [$request->candidate_id, '#family'])->with('success', 'Family member added successfully.');
    }
    public function familyDelete($id)
    {
        if (is_null($this->user) || !$this->user->can('candidate.family.delete')) {
            abort(403, 'Unauthorized');
        }
        $candidate = CandidateFamily::find($id);
        $candidate_id = $candidate->id;
        $candidate->delete();

        return redirect()->route('candidate.edit', [$candidate_id, '#family'])->with('success', 'Family member removed successfully.');
    }

    public function timeSheetData($sheetTypeId)
    {
        // if (is_null($this->user) || !$this->user->can('candidate.timesheet.data')) {
        //     abort(403, 'Unauthorized');
        // }
        $timeSheet = TimeSheet::with('entries')
            ->find($sheetTypeId);

        $data = [
            'sunday'    => $timeSheet->entries->where('day', 'Sunday')->first(),
            'monday'    => $timeSheet->entries->where('day', 'Monday')->first(),
            'tuesday'   => $timeSheet->entries->where('day', 'Tuesday')->first(),
            'wednesday' => $timeSheet->entries->where('day', 'Wednesday')->first(),
            'thursday'  => $timeSheet->entries->where('day', 'Thursday')->first(),
            'friday'    => $timeSheet->entries->where('day', 'Friday')->first(),
            'saturday'  => $timeSheet->entries->where('day', 'Saturday')->first(),
        ];

        return response()->json($data);
    }

    public function candidates_edit_remark(candidate $candidate, CandidateRemark $remark)
    {
        if (is_null($this->user) || !$this->user->can('candidate.edit')) {
            abort(403, 'Unauthorized');
        }
        $auth = Auth::user()->employe;

        $fileTypes = Uploadfiletype::where('uploadfiletype_status', 1)->where('uploadfiletype_for', 1)->latest()->get();
        $department_data = Department::orderBy('department_seqno')->where('department_status', '1')->get();
        $designation_data = Designation::orderBy('designation_seqno')->where('designation_status', '1')->get();
        $paymode_data = Paymode::orderBy('paymode_seqno')->where('paymode_status', '1')->get();
        $race_data = Race::orderBy('race_seqno')->where('race_status', '1')->get();
        $marital_data = MaritalStatus::orderBy('marital_statuses_seqno')->where('marital_statuses_status', '1')->get();
        $passtype_data = Passtype::orderBy('passtype_seqno')->where('passtype_status', '1')->get();
        $religion_data = religion::orderBy('religion_seqno')->where('religion_status', '1')->get();
        $outlet_data = Outlet::orderBy('id')->get();
        $client_files = ClientUploadFile::where('client_id', $candidate->id)->where('file_type_for', 1)->get();
        $remarks_type = Remarkstype::where('remarkstype_status', 1)->select('id', 'remarkstype_code')->latest()->get();
        $client_remarks = CandidateRemark::where('candidate_id', $candidate->id)->latest()->get();
        $job_types = Jobtype::where('jobtype_status', 1)->select('id', 'jobtype_code')->get();
        $clients = Client::where('clients_status', 1)->latest()->get();
        $payrolls = CandidatePayroll::where('candidate_id', $candidate->id)->latest()->get();
        $families = CandidateFamily::where('candidate_id', $candidate->id)->latest()->get();
        $time = CandidateWorkingHour::where('candidate_id', $candidate->id)->first();
        $candidate_resume = CandidateResume::where('candidate_id', $candidate->id)->latest()->get();
        $nationality = Country::orderBy('en_country_name')->get();
        $users = Employee::where('roles_id', 4)->where('id', '!=', $auth->id)->latest()->get();
        $Paybanks = Paybank::orderBy('Paybank_seqno')->select('id', 'Paybank_code')->where('Paybank_status', 1)->get();
        $time_sheet = TimeSheet::latest()->get();

        return view('admin.candidate.remarkedit', compact('Paybanks', 'fileTypes', 'client_files', 'candidate', 'outlet_data', 'religion_data', 'passtype_data', 'marital_data', 'race_data', 'department_data', 'designation_data', 'paymode_data', 'remarks_type', 'client_remarks', 'job_types', 'clients', 'payrolls', 'time', 'families', 'candidate_resume', 'nationality', 'users', 'time_sheet', 'remark'));
    }

    public function candidate_remark_update(Request $request, CandidateRemark $remark)
    {
        // return $request;
        $url = '/ATS/candidate/' . $remark->candidate_id . '/edit#remark';

        $auth = Auth::user()->employe;
        $validator = Validator::make($request->all(), [
            'remarks' => 'string|required',
            'ar_no' => 'string|nullable',
            'assign_to' => 'numeric|nullable',
            'client_company' => 'numeric|nullable',
        ]);

        if ($validator->fails()) {
            return redirect($url)
            ->withErrors($validator)
            ->withInput();
        }

        $validated = $validator->validated();
        $validated['modify_by'] = $auth->id;

        $candidate = Candidate::find($remark->candidate_id);

        if (!$candidate) return redirect($url)->with('error', 'Candidate Not Found!!');

        $dashboard = Dashboard::where('candidate_id', $request->candidate_id)->first();


        // try {
        //     // Begin a transaction
        //     DB::beginTransaction();

            $auth = Auth::user()->employe;

            $candidate_remark = $remark->update([
                'candidate_id' => $candidate->id,
                'remarkstype_id' => $remark->remarkstype_id,
                'isNotice' => $request->isNotice ?? 0,
                'remarks' => $request->remarks,
                'ar_no' => $request->client_ar_no,
                'assign_to' => $request->Assign_to_manager ?? $request->Assign_to_manager_r,
                'client_company' => $request->client_company
            ]);

            $dashboard_data = [];
            // return $dashboard;
            $assign_dashboard_remark = assign_dashboard_remark_id($remark->remarkstype_id);
            $dashboard_data['remark_id'] = $assign_dashboard_remark['remark_id'];
            $dashboard_data['follow_day'] = $assign_dashboard_remark['follow_day'];
            $dashboard_data['callback'] = $assign_dashboard_remark['callback'];

            $calander = [
                'manager_id' => $candidate->manager_id,
                'teamleader_id' => $candidate->team_leader_id,
                'consultant_id' => $candidate->consultant_id,
                'candidate_remark_id' => $remark->id,
            ];

            if ($request->remarkstype_id == 1) {
                $team = get_team($request->Assign_to_manager);
                $request->Assign_to_manager = $team['manager_id'];
                $candidate->update([
                    'manager_id' => $team['manager_id'],
                    'team_leader_id' => $team['team_leader_id'],
                    'consultant_id' => $team['consultant_id'],
                ]);

                $dashboard_data['manager_id'] = $team['manager_id'];
                $dashboard_data['teamleader_id'] = $team['team_leader_id'];
                $dashboard_data['consultent_id'] = $team['consultant_id'];
            }

            // if ($request->remarkstype_id == 4) {
            //     $dashboard_data['follow_day'] = ++$dashboard->follow_day;
            // }

            // if ($request->remarkstype_id == 22) {
            //     $dashboard_data['callback'] = ++$dashboard->callback;

            //     $calander['title'] = '09:00 AM -' . $candidate->consultant?->employee_code . ' - Call Back -' . $candidate->candidate_name;

            //     $calander['date'] = twobusinessday($remark->created_at);
            //     $calander['status'] = 1;
            //     Calander::create($calander);
            // }

            // if ($request->remarkstype_id == 6) {
            //     $list = AssignClient::create([
            //         'client_id' => $request->assign_client_id,
            //         'candidate_remark_id' => $remark->id,
            //     ]);

            //     $calander['assign_client_id'] = $list->id;
            //     $calander['title'] = '09:00 AM -' . $candidate->consultant?->employee_code . ' - 2 Business Days Follow Up with Client -' . $list->client->client_name . ' - ' . $candidate->candidate_name;

            //     $calander['date'] = twobusinessday($list->created_at);
            //     $calander['status'] = 1;
            //     Calander::create($calander);
            // }

            // if ($request->remarkstype_id == 2) {
            //     $team = get_team($request->team_leader);
            //     $request->Assign_to_manager = $team['manager_id'];
            //     $candidate->update([
            //         'manager_id' => $team['manager_id'],
            //         'team_leader_id' => $team['team_leader_id'],
            //         'consultant_id' => $team['consultant_id'],
            //     ]);

            //     $dashboard_data['manager_id'] = $team['manager_id'];
            //     $dashboard_data['teamleader_id'] = $team['team_leader_id'];
            //     $dashboard_data['consultent_id'] = $team['consultant_id'];
            // }

            // if ($request->remarkstype_id == 12) {
            //     $team = get_team($request->Assign_to_manager);
            //     $request->Assign_to_manager = $team['manager_id'];
            //     $candidate->update([
            //         'manager_id' => $team['manager_id'],
            //         'team_leader_id' => $team['team_leader_id'],
            //         'consultant_id' => $team['consultant_id'],
            //     ]);

            //     $dashboard_data['manager_id'] = $team['manager_id'];
            //     $dashboard_data['teamleader_id'] = $team['team_leader_id'];
            //     $dashboard_data['consultent_id'] = $team['consultant_id'];
            // }

            // if ($request->remarkstype_id == 11) {
            //     $team = get_team($auth->id);
            //     $candidate->update([
            //         'manager_id' => $team['manager_id'],
            //         'team_leader_id' => $team['team_leader_id'],
            //         'consultant_id' => $team['consultant_id'],
            //     ]);

            //     $dashboard_data['manager_id'] = $team['manager_id'];
            //     $dashboard_data['teamleader_id'] = $team['team_leader_id'];
            //     $dashboard_data['consultent_id'] = $team['consultant_id'];
            // }

            // if ($request->remarkstype_id == 3) {
            //     $team = get_team($request->rc);
            //     $candidate->update([
            //         'manager_id' => $team['manager_id'],
            //         'team_leader_id' => $team['team_leader_id'],
            //         'consultant_id' => $team['consultant_id'],
            //     ]);

            //     $dashboard_data['manager_id'] = $team['manager_id'];
            //     $dashboard_data['teamleader_id'] = $team['team_leader_id'];
            //     $dashboard_data['consultent_id'] = $team['consultant_id'];

            //     AssignToRc::create([
            //         'candidate_id' => $request->candidate_id,
            //         'rc_id' => $request->rc,
            //     ]);

            //     $rework = AssignToRc::where('candidate_id', $request->candidate_id)
            //         ->where('rc_id', $request->rc)
            //         ->count();
            //     if ($rework >= 2) {
            //         $dashboard_data['remark_id'] = 11;
            //     }
            // }

            // if ($request->remarkstype_id == 9) {
            //     $team = get_team($request->Assign_to_manager);
            //     $request->Assign_to_manager = $team['manager_id'];

            //     $candidate->update([
            //         'manager_id' => $team['manager_id'],
            //         'team_leader_id' => $team['team_leader_id'],
            //         'consultant_id' => $team['consultant_id'],
            //     ]);

            //     $dashboard_data['manager_id'] = $team['manager_id'];
            //     $dashboard_data['teamleader_id'] = $team['team_leader_id'];
            //     $dashboard_data['consultent_id'] = $team['consultant_id'];
            // }

            // if ($request->remarkstype_id == 7) {
            //     $list = CandidateRemarkShortlist::create([
            //         'candidate_remark_id' => $remark->id,
            //         'salary' => $request->shortlistSalary,
            //         'depertment' => $request->shortlistDepartment,
            //         'hourly_rate' => $request->shortlistHourlyRate,
            //         'placement_recruitment_fee' => $request->shortlistPlacement,
            //         'admin_fee' => $request->shortlistAdminFee,
            //         'start_date' => $request->shortlistStartDate,
            //         'end_date' => $request->shortlistContractEndDate,
            //         'job_title' => $request->shortlistJobTitle,
            //         'reminder_period' => $request->shortlistReminderPeriod,
            //         'job_type' => $request->shortlistJobType,
            //         'contact_signing_time' => $request->shortlistContractSigningTime,
            //         'contact_signing_date' => $request->shortlistContractSigningDate,
            //         'probition_period' => $request->shortlistProbationPeriod,
            //         'last_day' => $request->shortlistLastDay,
            //         'email_notice_time' => $request->shortlistEmailNoticeTime,
            //         'email_notice_date' => $request->shortlistEmailNoticeDate,
            //     ]);

            //     $calander['candidate_remark_shortlist_id'] = $list->id;
            //     if ($list->end_date != null) {
            //         $week_day = week_calculation($request->shortlistReminderPeriod);
            //         $endDate = Carbon::parse($list->end_date);
            //         $newEndDate = $endDate->subDays($week_day);

            //         $calander['title'] = $candidate->consultant?->employee_code . ' - Contract Ending - ' . $remark->client->client_name . ' - ' . $candidate->candidate_name;
            //         $calander['date'] = $newEndDate;
            //         $calander['status'] = 4;
            //         Calander::create($calander);
            //     }
            //     if ($list->start_date != null) {
            //         $calander['title'] = $candidate->consultant?->employee_code . ' - Shortlisted -' . $remark->client->client_name . ' - ' . $candidate->candidate_name;
            //         $calander['date'] = $list->start_date;
            //         $calander['status'] = 2;
            //         Calander::create($calander);
            //     }
            //     if ($list->contact_signing_date != null) {
            //         $calander['title'] =
            //         Carbon::parse($list->interview_time)->format('h:i A') . '-' . $candidate->consultant?->employee_code . ' - Contact Signing -' . $remark->client->client_name . ' - ' . $candidate->candidate_name;
            //         $calander['date'] = $list->contact_signing_date;
            //         $calander['status'] = 3;
            //         Calander::create($calander);
            //     }
            // }

            // if ($request->remarkstype_id == 5) {
            //     $list = CandidateRemarkInterview::create([
            //         'candidate_remark_id' => $remark->id,
            //         'interview_date' => $request->interview_date,
            //         'interview_time' => $request->interview_time,
            //         'interview_by' => $request->interview_by,
            //         'interview_position' => $request->interview_position,
            //         'interview_company' => $request->interview_company,
            //         'expected_salary' => $request->interview_expected_salary,
            //         'job_offer_salary' => $request->inteview_job_offer_salary,
            //         'available_date' => $request->available_date,
            //         'receive_job_offer' => $request->interview_received_job_offer,
            //         'email_notice_date' => $request->interviewEmailNoticeDate,
            //         'attend_interview' => $request->attendInterview,
            //     ]);

            //     $calander['candidate_remark_shortlist_id'] = $list->id;
            //     $calander['title'] = Carbon::parse($list->interview_time)->format('h:i A') . '-' . $candidate->consultant?->employee_code . ' - Interview -' . $list->company->client_name . ' - ' . $candidate->candidate_name;
            //     $calander['date'] = $list->interview_date;
            //     $calander['status'] = 1;
            //     $test = Calander::create($calander);
            // }

            $dashboard->update($dashboard_data);

            $candidate = Candidate::find($remark->candidate_id);
            $assign = Assign::where('remark_id', $remark->id);
            $assign->update([
                'candidate_id' => $candidate->id,
                'manager_id' => $request->Assign_to_manager ?? $candidate->manager_id,
                'teamleader_id' => $candidate->team_leader_id ?? null,
                'consultent_id' => $candidate->consultant_id ?? null,
                'update_by' => Auth::user()->id,
            ]);

            // DB::commit();
            return redirect($url)->with('success', 'Remark added successfully.');
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     return redirect($url)->with('error', $e->getMessage());
        // }
    }
}
