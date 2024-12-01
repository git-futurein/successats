<?php

namespace App\Models;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Support\Facades\Auth;

class candidate extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();


        static::created(function ($candidate) {
            $candidate->created_by = Auth::user()->id;

            $candidate->save();
        });

        // Update field update_by with current user id each time article is updated.
        static::updating(function ($candidate) {
            $candidate->modify_by = Auth::user()->id;
            // $candidate->save();
        });
    }


    public function Department()
    {
        return $this->belongsTo('App\Models\Department', 'departments_id');
    }

    public function outlet()
    {
        return $this->belongsTo('App\Models\outlet', 'employee_outlet_id');
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

    public function Designation()
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

    public function resumes(): HasMany
    {
        return $this->hasMany(CandidateResume::class, 'candidate_id');
    }

    public function activeResume()
    {
        $mainResume = $this->resumes->where('isMain', 1)->first();
        return $mainResume ? $mainResume->resume_file_path : null;
    }

    public function getMainResumeFilePath()
    {
        $mainResume = $this->resumes->where('isMain', 1)->first();
        return $mainResume ? $mainResume->resume_file_path : null;
    }

    public function remarks(): HasMany
    {
        return $this->hasMany(CandidateRemark::class, 'candidate_id');
    }

    public function attendences(): HasMany
    {
        return $this->hasMany(Attendance::class, 'parent_id',);
    }
    public function leaves(): HasMany
    {
        return $this->hasMany(Leave::class, 'candidate_id',);
    }

    public function working_hour(): HasOne
    {
        return $this->hasOne(CandidateWorkingHour::class, 'candidate_id');
    }

    public function team_leader(): BelongsTo
    {
        return $this->BelongsTo(Employee::class, 'team_leader_id');
    }

    public function consultant(): BelongsTo
    {
        return $this->BelongsTo(Employee::class, 'consultant_id');
    }

    public function manager(): BelongsTo
    {
        return $this->BelongsTo(Employee::class, 'manager_id');
    }
}
