<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportCandidateData extends Model
{
    protected $guarded = ['_token'];
    use HasFactory;

    public function importatedData() {
        return $this->belongsTo(TemporaryImportedData::class, 'resume_path');
    }
}
