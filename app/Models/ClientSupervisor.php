<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientSupervisor extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function department_name(): BelongsTo
    {
        return $this->belongsTo(ClientDepartment::class, 'department');
    }
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
