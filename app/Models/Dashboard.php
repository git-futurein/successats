<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dashboard extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function candidate(): BelongsTo
    {
        return $this->belongsTo(candidate::class, 'candidate_id');
    }
    public function client(): BelongsTo
    {
        return $this->belongsTo(client::class, 'client_company');
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'manager_id');
    }

    public function teamleader(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'teamleader_id');
    }

    public function consultent(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'consultent_id');
    }

    public function remark(): BelongsTo
    {
        return $this->belongsTo(remarkstype::class, 'remark_id');
    }

    public function candidate_remark(): BelongsTo
    {
        return $this->belongsTo(CandidateRemark::class, 'candidate_remark_id');
    }
}
