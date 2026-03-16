<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanningComment extends Model
{
    protected $table = 'planning_comments';

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
