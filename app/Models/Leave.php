<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    public $timestamps = false;

    /**
     * Get the teacher that owns the leave record.
     */
    public function teacher()
    {
        return $this->belongsTo('App\Models\Teacher');
    }
}
