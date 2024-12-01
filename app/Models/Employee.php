<?php

namespace App\Models;

use App\Models\Designation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class Employee extends Model
{
    use HasFactory,  Notifiable;

    protected $guarded = ['_token'];

    public static function boot()
    {
        parent::boot();
        static::created(function ($employee) {
            $employee->created_by = Auth::user()->id;
            $employee->save();
        });

        // Update field update_by with current user id each time article is updated.
        static::updating(function ($employee) {
            $employee->modify_by = Auth::user()->id;
            // $candidate->save();
        });
    }

    public function Department()
    {
        return $this->belongsTo('App\Models\Department', 'departments_id');
    }

    public function outlet()
    {
        return $this->belongsTo('App\Models\Outlet', 'employee_outlet_id');
    }

    public function passtype()
    {
        return $this->belongsTo('App\Models\passtype', 'passtypes_id');
    }

    public function User()
    {
        return $this->belongsTo('App\Models\User', 'users_id');
    }

    public function paymode()
    {
        return $this->belongsTo('App\Models\paymode', 'paymodes_id');
    }

    public function Designation(): BelongsTo
    {
        return $this->belongsTo(Designation::class, 'designations_id');
    }

    public function dbsex()
    {
        return $this->belongsTo('App\Models\dbsex', 'dbsexes_id');
    }

    public function maritalStatus()
    {
        return $this->belongsTo('App\Models\maritalStatus', 'marital_status_id');
    }

    public function Race()
    {
        return $this->belongsTo('App\Models\Race', 'races_id');
    }
    public function role_data()
    {
        return $this->belongsTo('Spatie\Permission\Models\Role', 'roles_id');
    }

    public function Religion()
    {
        return $this->belongsTo('App\Models\Religion', 'religions_id');
    }

    public function consultants(): HasMany
    {
        return $this->hasMany(Employee::class, 'team_leader_users_id');
    }

    public static function getCandidatesForManager($managerId)
    {
        $teamLeader = self::where('manager_users_id', $managerId)->first();

        if ($teamLeader) {
            $candidatesForManager = candidate::where('team_leader_id', $teamLeader->id)->get();
            return $candidatesForManager->toArray();
        }

        return [];
    }

    public static function getCandidatesForManagerActiveResumes($managerId)
    {
        $teamLeader = self::where('manager_users_id', $managerId)->first();

        if ($teamLeader) {
            $candidatesForManager = candidate::where('team_leader_id', $teamLeader->id)
                // ->whereHas('remarks', function ($query) {
                //     $query->where('remarkstype_id', 4);
                // })
                // ->with(['remarks' => function ($query) {
                //     $query->where('remarkstype_id', 4)
                //         ->latest()
                //         ->limit(1);
                // }])
                ->get();

            return $candidatesForManager;
        }

        return [];
    }
    public static function getCandidatesForManagerKIV($managerId)
    {
        $teamLeader = self::where('manager_users_id', $managerId)->first();

        if ($teamLeader) {
            $candidatesForManager = candidate::where('team_leader_id', $teamLeader->id)
                ->whereHas('remarks', function ($query) {
                    $query->where('remarkstype_id', 4);
                })
                ->with(['remarks' => function ($query) {
                    $query->where('remarkstype_id', 4)
                        ->latest()
                        ->limit(1);
                }])
                ->get();

            return $candidatesForManager;
        }

        return [];
    }

    public static function getCandidatesForManagerLatestRemark($managerId)
    {
        $teamLeader = self::where('manager_users_id', $managerId)->first();

        if ($teamLeader) {
            $candidatesForManager = candidate::where('team_leader_id', $teamLeader->id)
                ->whereHas('remarks', function ($query) {
                    $query->where('remarkstype_id', 4);
                })
                ->with(['remarks' => function ($query) {
                    $query->where('remarkstype_id', 4)
                        ->latest()
                        ->limit(1);
                }])
                ->get();

            $currentDate = Carbon::now();

            $candidatesGrouped = [
                '1' => [],
                '2' => [],
                '3' => [],
                '4' => [],
                '5' => [],
                '6' => []
            ];

            foreach ($candidatesForManager as $candidate) {
                $latestRemark = $candidate->remarks->first();
                $daysDifference = $currentDate->diffInDays(Carbon::parse($latestRemark->created_at));

                if ($daysDifference === 0) {
                    $candidatesGrouped['1'][] = $candidate;
                } elseif ($daysDifference === 1) {
                    $candidatesGrouped['2'][] = $candidate;
                } elseif ($daysDifference === 2) {
                    $candidatesGrouped['3'][] = $candidate;
                } elseif ($daysDifference === 3) {
                    $candidatesGrouped['4'][] = $candidate;
                } elseif ($daysDifference === 4) {
                    $candidatesGrouped['5'][] = $candidate;
                } else {
                    $candidatesGrouped['more_than_five_days'][] = $candidate;
                }
            }

            return $candidatesGrouped;
        }

        return [];
    }
    public static function getCandidatesForManagerInterviews($managerId)
    {
        $teamLeader = self::where('manager_users_id', $managerId)->first();

        if ($teamLeader) {
            $candidatesForManager = candidate::where('team_leader_id', $teamLeader->id)
                ->whereHas('remarks', function ($query) {
                    $query->where('remarkstype_id', 5);
                })
                ->with(['remarks' => function ($query) {
                    $query->where('remarkstype_id', 5)
                        ->latest()
                        ->limit(1);
                }])
                ->get();

            return $candidatesForManager;
        }

        return [];
    }
    public static function getCandidatesForManagerblackListed($managerId)
    {
        $teamLeader = self::where('manager_users_id', $managerId)->first();

        if ($teamLeader) {
            $candidatesForManager = candidate::where('team_leader_id', $teamLeader->id)
                ->whereHas('remarks', function ($query) {
                    $query->where('remarkstype_id', 11);
                })
                ->with(['remarks' => function ($query) {
                    $query->where('remarkstype_id', 11)
                        ->latest()
                        ->limit(1);
                }])
                ->get();

            return $candidatesForManager;
        }

        return [];
    }
    public static function getCandidatesForManagerassignToClient($managerId)
    {
        $teamLeader = self::where('manager_users_id', $managerId)->first();

        if ($teamLeader) {
            $candidatesForManager = candidate::where('team_leader_id', $teamLeader->id)
                ->whereHas('remarks', function ($query) {
                    $query->where('remarkstype_id', 6);
                })
                ->with(['remarks' => function ($query) {
                    $query->where('remarkstype_id', 6)
                        ->latest()
                        ->limit(1);
                }])
                ->get();

            return $candidatesForManager;
        }

        return [];
    }

    public static function getCandidatesForTeamLeader($teamLeaderId)
    {
        $candidatesForTeamLeader = candidate::where('team_leader_id', $teamLeaderId)->get();

        return $candidatesForTeamLeader->toArray();
    }
    public static function getCandidatesForConsultent($consultentId)
    {
        $candidatesForConsultent = candidate::where('consultant_id', $consultentId)->get();

        return $candidatesForConsultent->toArray();
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'manager_id');
    }

    public function teamleaders()
    {
        return $this->hasMany(Employee::class, 'user_table_id', 'id');
    }
}
