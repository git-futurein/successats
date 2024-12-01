<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ClientDepartment extends Model
{
    use HasFactory;
    protected $guarded = ['_token'];

    public static function boot()
    {
        parent::boot();
        static::created(function ($client_id) {
            $client_id->created_by = Auth::user()->id;
            $client_id->save();
        });

        // Update field update_by with current user id each time article is updated.
        static::updating(function ($client_id) {
            $client_id->modify_by = Auth::user()->id;
            // $client->save();
        });
    }
}
