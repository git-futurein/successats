<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsTo;

class JobApplication extends Model
{
    protected $guarded = ['_token'];
    use HasFactory;

    public function candidate(): belongsTo
    {
        return $this->belongsTo(candidate::class, 'candidate_id');
    }

    public function job(): BelongsTo
    {
        return $this->belongsTo(job::class, 'job_ids');
    }
}
