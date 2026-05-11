<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseStage extends Model
{
    protected $fillable = [
        'name_en',
        'name_ar',
        'sort_order',
        'is_final',
    ];
}
