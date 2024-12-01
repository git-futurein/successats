<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;

class client extends Model
{
    use HasFactory;

    protected $guarded = ['_token'];

    public static function boot()
    {
        parent::boot();
        static::created(function ($client) {
            $client->created_by = Auth::user()->id;
            $client->save();
        });

        // Update field update_by with current user id each time article is updated.
        static::updating(function ($client) {
            $client->modify_by = Auth::user()->id;
            // $client->save();
        });
    }
    public function industry_type()
    {
        return $this->belongsTo(jobcategory::class, 'industry_types_id');
    }

    // public function industry_type()
    // {
    //     return $this->belongsTo(IndustryType::class, 'industry_types_id');
    // }

    public function Employee()
    {
        return $this->belongsTo(Employee::class,'employees_id');
    }

    public function Employee_Payroll()
    {
        return $this->belongsTo(Employee::class,'payroll_employees_id');
    }
    public function followUps()
    {
        return $this->hasMany(ClientFollowUp::class, 'clients_id');
    }

    public function supervisors()
    {
        return $this->hasMany(ClientSupervisor::class, 'client_id');
    }

    // You can also define a method to get the latest follow-up
    public function latestFollowUp()
    {
        return $this->followUps()->latest()->first();
    }

    public function team_leader(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'payroll_employees_id');
    }

    public function tnc_template(): BelongsTo
    {
        return $this->belongsTo(TncTemplate::class, 'tnc_templates_id');
    }
}
