<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanningIndicators extends Model
{
    protected $table = 'planning_indicators';

    public function assessments()
    {
        return $this->hasMany(PlanningAssess::class, 'indicator_id');
    }

    public function comments()
    {
        return $this->hasMany(PlanningComment::class, 'indicator_id');
    }
}
