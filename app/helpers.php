<?php

use App\Models\Dashboard;
use App\Models\Employee;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use Smalot\PdfParser\Parser;

if (!function_exists('authRoleName')) {
    function authRoleName()
    {
        $roleName = '';
        $user = auth()->user();
        if ($user) {
            $roleName = $user->roleName($user->role);
        }
        return $roleName;
    }
}

if (!function_exists('manager')) {
    function manager()
    {
        $role = Role::select('id')->where('name', 'Manager')->first();

        $manager = Employee::select('id', 'employee_name')->where('roles_id', $role->id)->first();
        return $manager;
    }
}

if (!function_exists('manager_for_client')) {
    function manager_for_client()
    {
        $role = Role::select('id')->where('name', 'Manager')->first();

        $manager = Employee::select('id', 'employee_name')->where('roles_id', $role->id)->get();
        return $manager;
    }
}

if (!function_exists('teamLeaders')) {
    function teamLeaders()
    {
        $role = Role::select('id')->where('name', 'Team Leader')->first();

        $teamLeaders = Employee::select('id', 'employee_name')->where('roles_id', $role->id)->get();
        return $teamLeaders;
    }
}

if (!function_exists('candidate_group')) {
    function candidate_group($candidate_id)
    {
        $dashboard = Dashboard::where('candidate_id', $candidate_id)->first();

        return ($dashboard->manager->employee_code ?? '') . '/' . ($dashboard->teamleader->employee_code ?? '') . '/' . ($dashboard->consultent->employee_code ?? '');
    }
}

if (!function_exists('assign_dashboard_remark_id')) {
    function assign_dashboard_remark_id($id)
    {
        $data = [];
        $data['follow_day'] = 0;
        $data['callback'] = 0;
        if($id == 1 || $id == 2 || $id == 3 || $id == 9 || $id == 10 || $id == 11 || $id == 12) {
            $data['remark_id'] = 0;
        } elseif ($id == 4) {
            $data['remark_id'] = 6;
        } elseif ($id == 5) {
            $data['remark_id'] = 4;
        } elseif ($id == 6) {
            $data['remark_id'] = 5;
        } elseif ($id == 7) {
            $data['remark_id'] = 99;
        } elseif ($id == 22) {
            $data['remark_id'] = 22;
        }

        return $data;
    }
}

if (!function_exists('get_team')) {
    function get_team($emp_id)
    {
        $emp = Employee::find($emp_id);
        $data = [];
        $data['manager_id'] =  null;
        $data['team_leader_id'] =  null;
        $data['consultant_id'] =  null;
        if($emp->roles_id == 4){
            $data['manager_id'] = $emp->id;
        } elseif($emp->roles_id == 11) {
            $data['manager_id'] =  $emp->manager_users_id;
            $data['team_leader_id'] =  $emp->id;
        } elseif($emp->roles_id == 8) {
            $data['manager_id'] =  $emp->manager_users_id;
            $data['team_leader_id'] =  $emp->team_leader_users_id;
            $data['consultant_id'] =  $emp->id;
        }

        return $data;
    }
}

if (!function_exists('generate_text')) {
    function generate_text($file)
    {
        $resume_text = '';
        $file = $file;
        $filePath = public_path('/storage/' . $file);
        if (pathinfo($file, PATHINFO_EXTENSION) === 'docx') {
        } elseif (pathinfo($file, PATHINFO_EXTENSION) === 'pdf') {
            try {
                $parser = new Parser();
                $pdf = $parser->parseFile($filePath);

                $resume_text = $pdf->getText();
            } catch (\Exception $e) {
                return response('Error reading PDF: ' . $e->getMessage(), 500);
            }
        } elseif (pathinfo($file, PATHINFO_EXTENSION) === 'xls || xlsx') {
        } elseif (pathinfo($file, PATHINFO_EXTENSION) === 'doc') {
        }

        return $resume_text;
    }
}

if (!function_exists('convert_lunch_to_minutes')) {
    function convert_lunch_to_minutes($lunchHour)
    {
        switch ($lunchHour) {
            case '30 minutes':
                return 30;
            case '45 minutes':
                return 45;
            case '1 hour':
                return 60;
            case '1.5 hour':
                return 90;
            case '2 hour':
                return 120;
            case 'No Lunch':
                return 0;
            default:
                return 0;
        }
    }
}

if (!function_exists('week_calculation')) {
    function week_calculation($week)
    {
        switch ($week) {
            case '1 Week Before':
                return 6;
            case '2 Week Before':
                return 13;
            case '3 Week Before':
                return 20;
            case '4 Week Before':
                return 27;
            case '5 Week Before':
                return 34;
            case '6 Week Before':
                return 41;
            case '7 Week Before':
                return 48;
            case '8 Week Before':
                return 55;
            default:
                return 0;
        }
    }
}
if (!function_exists('twobusinessday')) {
    function twobusinessday($date)
    {
        $businessDaysToAdd = 2;
        for ($i = 0; $i < $businessDaysToAdd; $i++) {
            $date->addDay();
            if ($date->isWeekend()) {
                if ($date->isSaturday()) {
                    $date->addDay();
                } elseif ($date->isSunday()) {
                    $date->addDays(2);
                }
            }
        }
        return $date;
    }
}
if (!function_exists('twobusinessdayclient')) {
    function twobusinessdayclient($assignToClients)
    {
        $twobusinessday = [];
        foreach ($assignToClients as $assignToClient) {
            $date = Carbon::parse($assignToClient->updated_at);
            $businessDaysToAdd = 2;

            for ($i = 0; $i < $businessDaysToAdd; $i++) {
                $date->addDay();
                if ($date->isWeekend()) {
                    if ($date->isSaturday()) {
                        $date->addDay();
                    } elseif ($date->isSunday()) {
                        $date->addDays(2);
                    }
                }
            }
            if ($date->isPast()) {
                $twobusinessday[] = $assignToClient;
            }
        }

        return $twobusinessday;
    }
}

if (!function_exists('threebusinessdaynoaction')) {
    function threebusinessdaynoaction($dashboards)
    {
        $data = [];
        $threebusinessdaynoaction = [];
        $active_resume = [];
        foreach ($dashboards as $dashboard) {
            $date = Carbon::parse($dashboard->created_at);
            $businessDaysToAdd = 3;

            for ($i = 0; $i < $businessDaysToAdd; $i++) {
                $date->addDay();
                if ($date->isWeekend()) {
                    if ($date->isSaturday()) {
                        $date->addDay();
                    }
                    elseif ($date->isSunday()) {
                        $date->addDays(2);
                    }
                }
            }
            if ($date->isPast()) {
                $threebusinessdaynoaction[] = $dashboard;
            } else {
                $active_resume[] = $dashboard;
            }
        }
        $data['threebusinessdaynoaction'] = $threebusinessdaynoaction;
        $data['active_resume'] = $active_resume;

        return $data;
    }
}
