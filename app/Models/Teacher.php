<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    public $timestamps = false;
    
    /**
     * Get the combinations for the teacher
     */
    public function combinations()
    {
        return $this->hasMany('App\Models\Combination');
    }
}
