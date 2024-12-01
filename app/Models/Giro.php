<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Giro extends Model
{
    use HasFactory;
    protected $guarded = ['_token'];

    protected function bank() {
        return $this->belongsTo(Bank::class, 'bank_id');
    }
}
