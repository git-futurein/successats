<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class job extends Model
{
    use HasFactory;

    protected $guarded = ['_token'];

    public static function boot()
    {
        parent::boot();
        static::created(function ($job) {
            $job->created_by = Auth::user()->id;
            $job->save();
        });

        // Update field update_by with current user id each time article is updated.
        static::updating(function ($job) {
            $job->modify_by = Auth::user()->id;
            // $candidate->save();
        });
    }

    public function job_category() {
        return $this->belongsTo(jobcategory::class, 'job_category_id');
    }
    public function client() {
        return $this->belongsTo(client::class, 'client_id');
    }
    public function user() {
        return $this->belongsTo(User::class, 'person_incharge');
    }
    public function owner() {
        return $this->belongsTo(User::class, 'co_owner_id');
    }
    public function job_type() {
        return $this->belongsTo(jobtype::class, 'job_type_id');
    }
}
