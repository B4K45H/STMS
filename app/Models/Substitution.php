<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Substitution extends Model
{
    public $timestamps = false;

    /**
     * Get the combination that owns the substitution timetable entry.
     */
    public function combination()
    {
        return $this->belongsTo('App\Models\Combination');
    }
}
