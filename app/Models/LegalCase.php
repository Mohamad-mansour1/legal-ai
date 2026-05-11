<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LegalCase extends Model
{
    protected $fillable = [
        'client_id',
        'case_stage_id',
        'title',
        'case_number',
        'court',
        'status',
        'hearing_date',
        'description',
        'notes',
        'assigned_lawyer_id',
        'assigned_trainee_id',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function documents()
    {
        return $this->hasMany(CaseDocument::class);
    }

    public function stage()
    {
        return $this->belongsTo(CaseStage::class, 'case_stage_id');
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function hearings()
    {
        return $this->hasMany(Hearing::class)
            ->latest('hearing_date');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class)
            ->latest();
    }

    public function assignedLawyer()
    {
        return $this->belongsTo(User::class, 'assigned_lawyer_id');
    }

    public function assignedTrainee()
    {
        return $this->belongsTo(User::class, 'assigned_trainee_id');
    }
}
