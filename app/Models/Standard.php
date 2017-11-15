<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Standard extends Model
{
    /**
     * The subjects that belong to the standard.
     */
    public function subjects()
    {
        return $this->belongsToMany('App\Models\Subject')->withPivot('no_of_session_per_week');
    }
}
