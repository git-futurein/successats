<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dbsex extends Model
{
    use HasFactory;

    public function Employee(){
        return $this->hasMany('App\Models\Employee');
    }
}
