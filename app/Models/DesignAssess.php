<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DesignAssess extends Model
{
    protected $table = 'design_assessment';

    public function compliance()
    {
        return $this->belongsTo(DesignComplianceScore::class, 'compliances_id');
    }
}
