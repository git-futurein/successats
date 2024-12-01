<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AttendenceParent extends Model
{
    use HasFactory;
    protected $guarded = ['_token'];

    // public function company()
    // {
    //     return $this->belongsTo(Company::class, 'company_id', 'id');
    // }
    public function client()
    {
        return $this->belongsTo(client::class, 'company_id', 'id');
    }

    public function candidate()
    {
        return $this->belongsTo(candidate::class);
    }

    /**
     * Get all of the attendence for the AttendenceParent
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attendences(): HasMany
    {
        return $this->hasMany(Attendance::class, 'parent_id');
    }
}
