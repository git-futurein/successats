<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class uploadfiletype extends Model
{
    use HasFactory;

    protected $guarded = ['_token'];


    public static function boot()
    {
        parent::boot();
        static::created(function ($file_type) {
            $file_type->created_by = Auth::user()->id;
            $file_type->save();
        });

        // Update field update_by with current user id each time article is updated.
        static::updating(function ($file_type) {
            $file_type->modify_by = Auth::user()->id;
            // $client->save();
        });
    }
}
