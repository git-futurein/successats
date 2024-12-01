<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeSheetEntry extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function timeSheet()
    {
        return $this->belongsTo(TimeSheet::class);
    }
}
