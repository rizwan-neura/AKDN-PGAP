<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DesignIndicators extends Model
{
    protected $table = 'design_indicators';

    public function assessments()
    {
        return $this->hasMany(DesignAssess::class, 'indicator_id');
    }

    public function comments()
    {
        return $this->hasMany(DesignComment::class, 'indicator_id');
    }
}
