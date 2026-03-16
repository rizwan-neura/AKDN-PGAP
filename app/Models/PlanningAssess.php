<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanningAssess extends Model
{
    protected $table = 'planning_assessment';

    public function compliance()
    {
        return $this->belongsTo(PlanningComplianceScore::class, 'compliances_id');
    }
}
