<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeSheet extends Model
{
    use HasFactory;
    protected $guarded = ['_token'];

    public function entries()
    {
        return $this->hasMany(TimeSheetEntry::class);
    }
}
