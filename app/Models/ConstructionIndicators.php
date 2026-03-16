<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConstructionIndicators extends Model
{
    protected $table = 'construction_indicators';

    public function assessments()
    {
        return $this->hasMany(ConstructionAssess::class, 'indicator_id');
    }

    public function comments()
    {
        return $this->hasMany(ConstructionComment::class, 'indicator_id');
    }
}
