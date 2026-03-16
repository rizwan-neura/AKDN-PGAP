<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConstructionAssess extends Model
{
    protected $table = 'construction_assessment';

    public function compliance()
    {
        return $this->belongsTo(ConstructionComplianceScore::class, 'compliances_id');
    }
}
