<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class CandidatePayroll extends Model
{
    use HasFactory;
    protected $guarded = ['_token'];

    public static function boot()
    {
        parent::boot();
        static::created(function ($payroll) {
            $payroll->created_by = Auth::user()->id;
            $payroll->save();
        });

        // Update field update_by with current user id each time article is updated.
        static::updating(function ($payroll) {
            $payroll->modify_by = Auth::user()->id;
            // $client->save();
        });
    }

    public function outlet()
    {
        return $this->belongsTo(Outlet::class, 'client_company');
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(client::class, 'client_company', 'id');
    }
}
