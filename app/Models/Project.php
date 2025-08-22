<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
   // use SoftDeletes;

   public function current_phase()
    {
        return $this->hasOne(ProjectPhase::class,'id','phase_id');
    }
    public function organization()
    {
        return $this->hasOne(Organization::class,'id','organization_id');
    }
    public function building_type()
    {
        return $this->hasOne(BuildingType::class,'id','type_id');
    }



}
