<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\Employee;
class Designation extends Model
{
    use HasFactory;
    protected $guarded = ['_token'];

    public function Employee(): HasMany
    {
        return $this->hasMany(Employee::class);
    }
}
