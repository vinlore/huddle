<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accommodation extends Model
{
    public function rooms()
    {
        return $this->hasMany('App\Models\Room');
    }

    public function conferences()
    {
        return $this->belongsToMany('App\Models\Conference', 'conference_accommodations');
    }
}
