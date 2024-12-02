<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jobcategory extends Model
{
    use HasFactory;
    protected $guarded = ['_token'];

    public function parent() {
        return $this->belongsTo(jobtype::class, 'jobcategory_parent');
    }
}
