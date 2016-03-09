<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    // Each flight belongs to one conference.
    public function conference()
    {
        return $this->belongsTo('App\Models\Conference');
    }

    // Each flight takes many passengers.
    public function passengers()
    {
        return $this->belongsToMany('App\Models\Profile', 'profile_takes_flights');
    }
}
