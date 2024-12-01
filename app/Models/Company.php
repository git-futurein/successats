<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $guarded = ['_token'];

    // public function nationality() {
    //     return $this->belongsTo(Nationality::class, 'nationality_id');
    // }

    public function nationality()
    {
        return $this->belongsTo(country::class, 'nationality_id');
    }
}
