<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class TemporaryImportedData extends Model
{
    protected $guarded = ['_token'];

    use HasFactory;


    public static function boot()
    {
        parent::boot();
        static::created(function ($temp) {
            $temp->created_by = Auth::user()->id;
            $temp->save();
        });

        // Update field update_by with current user id each time article is updated.
        static::updating(function ($temp) {
            $temp->modify_by = Auth::user()->id;
            // $candidate->save();
        });
    }
}
