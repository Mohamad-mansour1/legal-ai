<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseDocument extends Model
{
    protected $fillable = [
        'legal_case_id',
        'title',
        'file_path',
        'file_name',
        'mime_type',
        'file_size',
    ];
    
    public function legalCase()
    {
        return $this->belongsTo(LegalCase::class);
    }
}
