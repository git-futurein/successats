<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class ClientFollowUp extends Model
{
    use HasFactory;

    protected $guarded = ['_token'];
    protected $fillable = ['description', 'clients_id', 'Create_by', 'Modify_by'];

    public static function boot()
    {
        parent::boot();
        static::created(function ($ClientFollowUp) {
            $ClientFollowUp->created_by = Auth::user()->id;
            $ClientFollowUp->save();
        });

        // Update field update_by with current user id each time article is updated.
        static::updating(function ($ClientFollowUp) {
            $ClientFollowUp->modify_by = Auth::user()->id;
        });
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(client::class, 'clients_id');
    }
}
