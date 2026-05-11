<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'legal_case_id',
        'user_id',
        'action',
        'description',
        'old_values',
        'new_values',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
    ];

    public function legalCase()
    {
        return $this->belongsTo(LegalCase::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}