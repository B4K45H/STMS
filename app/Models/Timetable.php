<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    protected $table    = 'timetable';
    public $timestamps  = false;

    /**
     * Get the combination that owns the timetable entry.
     */
    public function combination()
    {
        return $this->belongsTo('App\Models\Combination');
    }

    /**
     * Get the sessiom that owns the timetable entry.
     */
    public function session()
    {
        return $this->belongsTo('App\Models\Session');
    }
}
