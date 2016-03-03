<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accommodation extends Model
{
    // Each accommodation has many rooms.
    public function rooms()
    {
        return $this->hasMany('App\Models\Room');
    }

    // Each accommodation belongs to many conferences.
    public function conferences()
    {
        return $this->belongsToMany('App\Models\Conference', 'conference_accommodations');
    }
}
