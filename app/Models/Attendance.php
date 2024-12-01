<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\candidate;
use App\Models\Company;

class Attendance extends Model
{
    use HasFactory;
    protected $guarded = ['_token'];

    /**
     * Get the user that owns the phone.
     */
    public function candidate()
    {
        return $this->belongsTo(candidate::class);
    }

    /**
     * Get the user that owns the phone.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
