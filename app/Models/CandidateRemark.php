<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;

class CandidateRemark extends Model
{
    use HasFactory;
    protected $guarded = ['_token'];

    public static function boot()
    {
        parent::boot();
        static::created(function ($candidate_remark) {
            $candidate_remark->created_by = Auth::user()->id;
            $candidate_remark->save();
        });

        // Update field update_by with current user id each time article is updated.
        static::updating(function ($candidate_remark) {
            $candidate_remark->modify_by = Auth::user()->id;
            // $client->save();
        });
    }

    public function Assign()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function assign_d()
    {
        return $this->hasOne(Assign::class, 'remark_id');
    }

    public function remarksType()
    {
        return $this->belongsTo(remarkstype::class, 'remarkstype_id', 'id');
    }

    public function candidate(): BelongsTo
    {
        return $this->belongsTo(candidate::class, 'candidate_id');
    }

    /**
     * Get the outlet that owns the CandidateRemark
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(client::class, 'client_company', 'id');
    }

    /**
     * Get the user associated with the CandidateRemark
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function interview(): HasOne
    {
        return $this->hasOne(CandidateRemarkInterview::class, 'candidate_remark_id');
    }

    public function shortlist(): HasOne
    {
        return $this->hasOne(CandidateRemarkShortlist::class, 'candidate_remark_id');
    }

    public function assign_client(): HasOne
    {
        return $this->HasOne(AssignClient::class, 'candidate_remark_id', 'id');
    }

    public function assignTo()
    {
        return $this->belongsTo(Employee::class, 'assign_to');
    }
}


