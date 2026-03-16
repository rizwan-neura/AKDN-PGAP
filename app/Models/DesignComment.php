<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DesignComment extends Model
{
    protected $table = 'design_comments';

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
