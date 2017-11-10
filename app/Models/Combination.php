<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Combination extends Model
{
    /**
     * Get the classroom that owns the combination.
     */
    public function classroom()
    {
        return $this->belongsTo('App\Model\ClassRoom');
    }

    /**
     * Get the subject that owns the combination.
     */
    public function subject()
    {
        return $this->belongsTo('App\Model\Subject');
    }

    /**
     * Get the teacher that owns the combination.
     */
    public function teacher()
    {
        return $this->belongsTo('App\Model\Teacher');
    }
}
