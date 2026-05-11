<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hearing extends Model
{
    protected $fillable = [
        'legal_case_id',
        'title',
        'court',
        'hearing_date',
        'result',
        'notes',
        'status',
    ];

    public function legalCase()
    {
        return $this->belongsTo(LegalCase::class);
    }
}