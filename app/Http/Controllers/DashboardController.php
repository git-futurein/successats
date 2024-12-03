<?php

namespace App\Http\Controllers;

use App\Enums\CalanderStatus;
use App\Models\Assign;
use App\Models\Calander;
use App\Models\Callback;
use App\Models\Candidate;
use App\Models\CandidateRemark;
use App\Models\CandidateRemarkInterview;
use App\Models\client;
use App\Models\Dashboard;
use App\Models\Employee;
use App\Models\Jobtype;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;

class DashboardController extends Controller
{

    public function index()
    {
        if(!Auth::check())
        {
            return redirect()->route('login');
        }

        $auth = Auth::user()->employe;
        $managers = [];
        $candidatesByManager = [];
        $consultants = [];
        $candidatesByConsultent = [];
        $team_leaders = [];
        $candidatesByTeam = [];
        $own_manager = [];

        $users = Employee::where('roles_id', 4)->where('id', '!=', $auth->id)->latest()->get();
        $clients = client::latest()->get();
        $job_types = Jobtype::where('jobtype_status', 1)->select('id', 'jobtype_code')->get();


        $calander_datas = Calander::query();
        // $active_resume = Dashboard::with('candidate')->where('status', 0)->whereNot('remark_id',3)->whereNot('remark_id',2)->whereNot('remark_id',10)->whereNot('remark_id',8);
        $active_resume = Dashboard::with('candidate')->where('status', 0)->where('remark_id',0);
        $shortlists = Dashboard::with('candidate')->where('status', 0)->where('remark_id', 99);
        $rework = Dashboard::with('candidate')->where('status', 0)->where('remark_id', 11);
        $followUp = Dashboard::with('candidate')->where('status', 0)->where('remark_id', 6)->where('follow_day', '>', 0);

        $callback = Dashboard::with('candidate')->where('status', 0)->where('remark_id', 22)->where('callback', '>', 0);
        // $interviews = Dashboard::with('candidate', 'candidate_remark.interview')->where('status', 0)->where('remark_id', 5);
        $interviews = Dashboard::with('candidate', 'candidate_remark.interview')->where('status', 0)->where('remark_id', 4);//in dashboards table for interview the remark id is 4
        // dd($interviews->get());
        $assignToClients = Dashboard::with('candidate')->where('status', 0)->where('remark_id', 6);
        $kivs = Dashboard::with('candidate')->where('status', 0)->where('remark_id', 7);
        $blackListed = Dashboard::with('candidate')->where('status', 0)->whereIn('remark_id', [2, 3, 8, 10]);;

        if ($auth->roles_id == 1) {
            $managers = Employee::where('roles_id', 4)->get();
            foreach ($managers as $manager) {
                $candidatesByManager[$manager->id] = Dashboard::with('candidate')->where('status', 0)->where('manager_id', $manager->id)->get();
            }
        } elseif ($auth->roles_id == 4) {
            $calander_datas = $calander_datas->where('manager_id', $auth->id);
            $shortlists = $shortlists->where('manager_id', $auth->id);
            $rework = $rework->where('manager_id', $auth->id);
            $active_resume = $active_resume->where('manager_id', $auth->id);
            $interviews = $interviews->where('manager_id', $auth->id);
            $assignToClients = $assignToClients->where('manager_id', $auth->id);
            $kivs = $kivs->where('manager_id', $auth->id);
            $followUp = $followUp->where('manager_id', $auth->id);
            $callback = $callback->where('manager_id', $auth->id);

            $team_leaders = Employee::where('roles_id', 11)->where('manager_users_id', $auth->id)->get();

            foreach ($team_leaders as $team_leader) {
                $candidatesByTeam[$team_leader->id] = Dashboard::with('candidate')->where('status', 0)->where('teamleader_id', $team_leader->id)->get();

                $consultents_data = Employee::where('roles_id', 8)->where('team_leader_users_id', $team_leader->id)->get();
                foreach ($consultents_data as $consultent)
                {
                    $candidatesByConsultent[$consultent->id] = Dashboard::with('candidate')->where('status', 0)->where('consultent_id', $consultent->id)->get();

                    $consultants[] = $consultent;
                }
            }
        } elseif ($auth->roles_id == 11) {
            $own_manager = Dashboard::with('candidate')->where('manager_id', $auth->manager_users_id)->where('status', 0)->get();

            $calander_datas = $calander_datas->where('teamleader_id', $auth->id);
            $shortlists = $shortlists->where('teamleader_id', $auth->id);
            $rework = $rework->where('teamleader_id', $auth->id);
            $interviews = $interviews->where('teamleader_id', $auth->id);
            // $active_resume = $active_resume->where('teamleader_id', $auth->id);
            $assignToClients = $assignToClients->where('teamleader_id', $auth->id);
            $kivs = $kivs->where('teamleader_id', $auth->id);
            $followUp = $followUp->where('teamleader_id', $auth->id);
            $callback = $callback->where('teamleader_id', $auth->id);

            $consultents_data = Employee::where('roles_id', 8)->where('team_leader_users_id', $auth->id)->get();
            foreach ($consultents_data as $consultent) {
                $candidatesByConsultent[$consultent->id] = Dashboard::with('candidate')->where('status', 0)->where('consultent_id', $consultent->id)->get();

                $consultants[] = $consultent;
            }

        } elseif ($auth->roles_id == 8) {
            $calander_datas = $calander_datas->where('consultant_id', $auth->id);
            $shortlists = $shortlists->where('consultent_id', $auth->id);
            $rework = $rework->where('consultent_id', $auth->id);
            $active_resume = $active_resume->where('consultent_id', $auth->id);
            $interviews = $interviews->where('consultent_id', $auth->id);
            $assignToClients = $assignToClients->where('consultent_id', $auth->id);
            $kivs = $kivs->where('consultent_id', $auth->id);
            $followUp = $followUp->where('consultent_id', $auth->id);
            $callback = $callback->where('consultent_id', $auth->id);

            $consultents_data = Employee::where('id', $auth->id)->get();
            foreach ($consultents_data as $consultent) {
                $candidatesByConsultent[$consultent->id] = Dashboard::with('candidate')->where('status', 0)->where('consultent_id', $consultent->id)->get();

                $consultants[] = $consultent;
            }
        }

        $c_datas = $calander_datas->latest()->get();
        $calander_datas = [];
        foreach ($c_datas as $key => $remark) {
            // return $remark;
            $car = CandidateRemark::find($remark->candidate_remark_id);

            $calander_datas[] = [
                'id' => $remark->id,
                'candidate_remark_id' => $remark->candidate_remark_id,
                'candidate_remark_shortlist_id' => $remark->candidate_remark_shortlist_id,
                'title' => $remark->title,
                'date' => Carbon::parse($remark->date)->format('Y-m-d'),
                'allDay' => false,
                'url' => URL::to('ATS/candidates/edit/remark/'.$car->candidate_id.'/'.$remark->candidate_remark_id),
                'className' => 'bg-' . CalanderStatus::from($remark->status)->message(), // status
            ];
        }

        $interviews = $interviews->latest()->get();
        $assignToClients = $assignToClients->latest()->get();
        // $twobusinessdayclients = twobusinessdayclient($assignToClients);
        $kivs = $kivs->latest()->get();
        $followUp = $followUp->latest()->get();

        $callback = $callback->latest()->get();
        $shortlists = $shortlists->latest()->get();
        $rework = $rework->latest()->get();
        $blackListed = $blackListed->latest()->get();
        $activeResumes = $active_resume->latest()->get();
        // $threedaynoaction = $active_resume['threebusinessdaynoaction'];
        // $activeResumes = $active_resume['active_resume'];
        $interviewData = [];
        $threedaynoaction = [];
        foreach ($interviews as $key => $item) {
            if(isset($item->candidate_remark?->interview?->interview_date))
            {
                $interviewDate = $item->candidate_remark->interview->interview_date;
                $threeDaysAfterInterview = Carbon::parse($interviewDate)->addDays(3);

                $today = Carbon::today();

                if ($threeDaysAfterInterview->lessThanOrEqualTo($today)) {
                    $threedaynoaction[] = $item;
                } else {
                    $interviewData[] = $item;
                }

            }
        }

        $followUps[1] = [];
        $followUps[2] = [];
        $followUps[3] = [];
        $followUps[4] = [];
        $followUps[5] = [];
        $followUps[6] = [];

        $groupedFollowUps = $followUp->groupBy('follow_day');

        foreach ($groupedFollowUps as $followDay => $group) {
            switch ($followDay) {
                case 0:
                    break;
                case 1:
                    $followUps[1] = $group->all();
                    break;
                case 2:
                    $followUps[2] = $group->all();
                    break;
                case 3:
                    $followUps[3] = $group->all();
                    break;
                case 4:
                    $followUps[4] = $group->all();
                    break;
                case 5:
                    $followUps[5] = $group->all();
                    break;
                default:
                    $followUps[6] = array_merge($followUps[6], $group->all());
                    break;
            }
        }

        $callbacks[1] = [];
        $callbacks[2] = [];
        $callbacks[3] = [];
        $callbacks[4] = [];
        $callbacks[5] = [];
        $callbacks[6] = [];

        $groupedcallbacks = $callback->groupBy('callback');

        foreach ($groupedcallbacks as $callback => $group) {
            switch ($callback) {
                case 0:
                    break;
                case 1:
                    $callbacks[1] = $group->all();
                    break;
                case 2:
                    $callbacks[2] = $group->all();
                    break;
                case 3:
                    $callbacks[3] = $group->all();
                    break;
                case 4:
                    $callbacks[4] = $group->all();
                    break;
                case 5:
                    $callbacks[5] = $group->all();
                    break;
                default:
                    $callbacks[6] = array_merge($callbacks[6], $group->all());
                    break;
            }
        }

        $assignToClient[1] = [];
        $assignToClient[2] = [];

        $today = now()->toDateString();
        foreach ($assignToClients as $key => $assign) {
            if ($assign->updated_at->toDateString() == $today) {
                $assignToClient[1][] = $assign;
            } elseif($assign->updated_at->toDateString() < $today) {
                $assignToClient[2][] = $assign;
            }
        }

        return view('admin.dashboard', compact(
            'candidatesByManager',
            'calander_datas',
            'managers',
            'candidatesByTeam',
            'team_leaders',
            'candidatesByConsultent',
            'consultants',
            'followUps',
            'callbacks',
            'blackListed',
            'assignToClient',
            'kivs',
            'activeResumes',
            'shortlists',
            'rework',
            'own_manager',
            'interviewData',
            'threedaynoaction',
            'clients',
            'users',
            'job_types',
        ));
    }

    public function change_dashboard_remark(Dashboard $dashboard, $remarkId)
    {
        $candidateId = $dashboard->candidate_id;
        $candidate = Candidate::find($candidateId);
        if(!$candidate) return redirect()->back()->with('error', 'Candidate Not Found!!');

        try {
            DB::beginTransaction();
            $auth = Auth::user()->employe;

            //update callback table
            $callback = Callback::where('candidate_id', $candidate->id)->where('status', 5)->first();
            if($callback) {
                $callback->update(['status', 6]);
            }

            //create remark
            $candidate_remark               = new CandidateRemark();
            $candidate_remark->candidate_id = $candidate->id;
            $candidate_remark->ar_no        = 0;
            $candidate_remark->assign_to    = 0;
            $candidate_remark->created_by   = $auth->id;
            $dashboard_data['callback'] = ++$dashboard->callback;

            //active resume
            if ($remarkId == 0) {
                $candidate_remark->remarkstype_id   = 24;
                $candidate_remark->remarks          = 'Transition to Active Resume';
            }

            //faj
            if ($remarkId == 2) {
                $candidate_remark->remarkstype_id   = 25;
                $candidate_remark->remarks          = 'Transition to FAJ';
            }

            // Not Suitable
            if ($remarkId == 3) {
                $candidate_remark->remarkstype_id   = 26;
                $candidate_remark->remarks          = 'Transition to  Not Suitable';
            }

            //KIV
            if ($remarkId == 7) {
                $candidate_remark->remarkstype_id   = 27;
                $candidate_remark->remarks          = 'Transition to KIV';
            }

            //Drop
            if ($remarkId == 10) {
                $candidate_remark->remarkstype_id   = 28;
                $candidate_remark->remarks          = 'Transition to Drop';
            }

            //Blacklist
            if ($remarkId == 8) {
                $candidate_remark->remarkstype_id   = 29;
                $candidate_remark->remarks          = 'Transition to Blacklist';
            }

            //save  remark
            $candidate_remark->save();

            $dashboard_data = [];
            $assign_dashboard_remark = assign_dashboard_remark_id($remarkId);
            $dashboard_data['candidate_remark_id']  = $candidate_remark->id;
            $dashboard_data['remark_id']            = $remarkId;
            $dashboard_data['follow_day']           = $assign_dashboard_remark['follow_day'];
            $dashboard_data['callback']             = $assign_dashboard_remark['callback'];

            $dashboard->update($dashboard_data);
            $candidate = Candidate::find($candidateId);
            Assign::create([
                'candidate_id' => $candidate->id,
                'manager_id' => $request->Assign_to_manager ?? $candidate->manager_id,
                'teamleader_id' => $candidate->team_leader_id ?? null,
                'consultent_id' => $candidate->consultant_id ?? null,
                'insert_by' => Auth::user()->id,
                'remark_id' => $candidate_remark->id,
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Remark added successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    //candidate remark
    public function candidateRemark(Dashboard $dashboard){
        $candidateId = $dashboard->candidate_id;
        $candidateData = Candidate::where('id',$candidateId)->first(['candidate_name','candidate_nric']);
        $candidate_remarks = CandidateRemark::with('candidate','assignTo','client','assign_client','remarksType','Assign')->where('candidate_id',$candidateId)->latest()->get();

        return response()->json([
            'candidateData'     => $candidateData,
            'candidate_remarks' => $candidate_remarks,
        ]);
    }

    //dashboard candidate remarks
    public function DashboardCandidateRemark(Request $request){
        $dashboard  = Dashboard::where('id',$request->dashboardId)->first();
        $candidateId    = $dashboard->candidate_id;

        $validator = Validator::make($request->all(), [
            'candidate_id'          => 'required|integer',
            'remarkstype_id'        => 'required|integer',
            'isNotice'              => 'nullable',
            'remarks'               => 'required',
            'callbackDate'          => 'required_if:remarkstype_id,22',
            'callbackTime'          => 'required_if:remarkstype_id,22',
            'shortlistPlacement'    => 'nullable|numeric',
            'remarks'               => 'required|string',
        ]);

        if ($validator->fails()) {
            $errorMessage = $validator->errors()->first('candidate_id');
            return redirect()->back()
                ->with('error', $errorMessage)
                ->withInput();
        }

        $validator->validated();

        $candidate = Candidate::find($candidateId);

        if(!$candidate) return redirect()->back()->with('error', 'Candidate Not Found!!');

        // $dashboard = Dashboard::where('candidate_id', $request->candidate_id)->first();

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
            $candidate = Candidate::find($candidateId);
            Assign::create([
                'candidate_id' => $candidate->id,
                'manager_id' => $request->Assign_to_manager ?? $candidate->manager_id,
                'teamleader_id' => $candidate->team_leader_id ?? null,
                'consultent_id' => $candidate->consultant_id ?? null,
                'insert_by' => Auth::user()->id,
                'remark_id' => $candidate_remark->id,
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Remark added successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


}
