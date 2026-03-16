<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConstructionComment extends Model
{
    protected $table = 'construction_comments';

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
