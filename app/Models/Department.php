<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Department extends Model
{
    use HasFactory, LogsActivity;
    protected $guarded = ['_token'];

    public function getActivitylogOptions():LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['menu_group',
        'menu_icon',
        'menu_name',
        'menu_path',
        'menu_perent',
        'menu_status',
        'menu_short',
        'exception'])
        ->setDescriptionForEvent(fn(string $eventName) => Auth::user()->name." has been {$eventName}" )
        ->useLogName('MenuLogs')
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs();
    }

    protected static $logAttributes = [
        'menu_group',
        'menu_icon',
        'menu_name',
        'menu_path',
        'menu_perent',
        'menu_status',
        'menu_short',
        'exception'
    ];

}
