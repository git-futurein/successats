<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function Employee()
    {
        return $this->hasMany('App\Models\Employee');
    }

    public function nationality()
    {
        return $this->belongsTo(country::class, 'countries_id');
    }
}
