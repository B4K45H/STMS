<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassRoom extends Model
{
    /**
     * Get the combinations for the classroom
     */
    public function combinations()
    {
        return $this->hasMany('App\Models\Combination');
    }

    /**
     * Get the standard for the classroom.
     */
    public function standard()
    {
        return $this->belongsTo('App\Models\Standard');
    }

    /**
     * Get the division fors the classroom.
     */
    public function division()
    {
        return $this->belongsTo('App\Models\Division');
    }
}
