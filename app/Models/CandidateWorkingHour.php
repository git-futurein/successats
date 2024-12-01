<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CandidateWorkingHour extends Model
{
    use HasFactory;
    protected $guarded = ['_token'];

    public function timesheet(): HasOne
    {
        return $this->hasOne(User::class, 'timesheet_id');
    }
}
