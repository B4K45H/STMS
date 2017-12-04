<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['status'];

    /**
     * Get the teacher that owns the leave record.
     */
    public function teacher()
    {
        return $this->belongsTo('App\Models\Teacher');
    }
}
