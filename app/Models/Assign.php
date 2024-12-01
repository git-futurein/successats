<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Assign extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function candidate(): BelongsTo
    {
        return $this->belongsTo(candidate::class);
    }

    public function remark(): BelongsTo
    {
        return $this->belongsTo(remarkstype::class, 'remark_id');
    }
}
