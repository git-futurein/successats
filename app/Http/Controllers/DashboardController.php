<?php

namespace App\Http\Controllers;

use App\Enums\CalanderStatus;
use App\Models\Calander;
use App\Models\CandidateRemark;
use App\Models\client;
use App\Models\Dashboard;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

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

        $clients = client::latest()->get();
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
            'clients'
        ));
    }

    public function change_dashboard_remark(Dashboard $dashboard, $id)
    {
        // dd($dashboard);
        $follow_day = 0;
        if($id == 6)
        {
            $follow_day = ++$dashboard->follow_day;
        }

        //check for switch interview tab, is the required data are available in database
        if($id == 4){
            $candidateId    = $dashboard->candidate_id;
            $currentDate    = date('Y-m-d');
            $interviewDate  = CandidateRemark::withWhereHas('interview',function($query) use ($currentDate){
                                $query->where('interview_date', '>=', $currentDate);
                            })->where('candidate_id',$candidateId)
                            ->where('remarkstype_id',5) //in candidate_remarks table for interview the remark type id is 5
                            ->exists();

            if(!$interviewDate){
                // // session not working here
                // Cache::forget('emptyInterview');
                // Cache::put('emptyInterview', "no interview set");

                // return redirect()->back()->with('candidateId',  $candidateId );
                return redirect()->to('/ATS/candidate/' . $candidateId . '/edit#remark')->with('success','Interview Not Assigned! Please give interview details');

            }
        }

        $dashboard = $dashboard->update(['remark_id' => $id, 'follow_day' => $follow_day]);

        if (!$dashboard) {
            return redirect()->back()->with('error', 'Something Is Wrong!! Try Again.');
        }

        return redirect()->back()->with('success', 'Follow Up changed successfully.');
    }


    //interview assign
    public function interviewAssign(Request $request, $id){
        dd($request->all(),$id);
    }
}
