<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class ClientUploadFile extends Model
{
    use HasFactory;
    protected $guarded = ['_token'];

    public static function boot()
    {
        parent::boot();
        static::created(function ($ClientUploadFile) {
           $ClientUploadFile->created_by = Auth::user()->id;
            $ClientUploadFile->save();
        });

    }

    public function file_type()
    {
        return $this->belongsTo(uploadfiletype::class, 'file_type_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}
