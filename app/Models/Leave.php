<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class Leave extends Model
{
    use HasFactory;

    protected $guarded = ['_token'];
    public static function boot()
    {
        parent::boot();
        static::created(function ($Leave) {
            $Leave->created_by = Auth::user()->id;
            $Leave->save();
        });

        // Update field update_by with current user id each time article is updated.
        static::updating(function ($Leave) {
            $Leave->modify_by = Auth::user()->id;
            // $Leave->save();
        });
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employees_id');
    }

    
    public function candidate()
    {
        return $this->belongsTo(candidate::class, 'employees_id');
    }
    public function employee_type()
    {
        return $this->belongsTo(Role::class, 'leave_empl_type');
    }

    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class, 'leave_types_id');
    }
}
