<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    /**
     * The standards that belong to the subject.
     */
    public function standards()
    {
        return $this->belongsToMany('App\Models\Standard');
    }

    /**
     * Get the combinations for the subject
     */
    public function combinations()
    {
        return $this->hasMany('App\Models\Combination');
    }
}
